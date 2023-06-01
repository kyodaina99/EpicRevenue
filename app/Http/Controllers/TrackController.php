<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\Postback;
use App\Models\Report;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Helper;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use PhpParser\Node\Expr\Cast\Object_;
use Torann\GeoIP\GeoIP;

class TrackController extends Controller
{
    public function postback(Request $request, $veri_slot)
    {
        $postback = Postback::where('veri_slot', $veri_slot)->firstOrFail();
        $report = Report::where('credit_hash', $request->input($postback->ch_slot))->first();
        if( is_null($report) )
            return "Invalid Credit Var(". $request->input($postback->ch_slot) .")";
        if( (int) $report->status === 2 )
            return "Invalid Credit Var(". $request->input($postback->ch_slot) .")";

        $user = User::where('id', $report->user_id)->with('balance', 'balance.histories')->first();
        $amount = $request->has('amount') ? $request->input('amount') : null;

        $report->status = 2;
        $report->network_payout = $amount;
        $report->save();

        if( ! Helper::updateCash($user, $report) )
        {
            return "Sorry, Something went wrong!!!";
        }

        return $report->network_payout . "\n\n" . $report->credit_hash;
    }

    public function track(Request $request, $campaign_id, $user_id, $subid1 = null, $subid2 = null, $subid3 = null, $subid4 = null, $subid5 = null)
    {
        $user = User::where('id', $user_id)->approved()->first();
        $campaign = Campaign::where('id', $campaign_id)->active()->with(['reports', 'countries', 'targets', 'rates'])->first();
        $report = new Report();

        if(is_null($request->input('ip', null)))
            $geoIP = \GeoIP::getLocation();
        else
            $geoIP = \GeoIP::getLocation(urldecode($request->input('ip')));

        // Check if campaign exist or inactive
        if(is_null($campaign))
            return 'The campaign is either invalid or was expired.';
        // Check if user exist or inactive
        if(is_null($user))
            return 'The publisher account is either inactive or does not have permission to run this campaign.';
        // Check If user is from
        if( ! $this->checkIfFromAllowedCountries($campaign->countries, $geoIP) )
            return "Your country does not have permission to access this campaign.<br><br> COUNTRY: ".$geoIP->country." , STATE: ".$geoIP->state." , CITY: ".$geoIP->city." , ZIP: ".$geoIP->postal_code." , IP: ".$geoIP->ip." <br><br> ".$campaign->countries." ";
        // Check if cap is not set to unlimited
        if($campaign->cap !== 0)
        {
            // Check if total cap or daily cap reached
            if($this->checkTotalCap($campaign) || $this->checkDailyCap($campaign))
            {
                $campaign->active = 'no';
                $campaign->save();
                return "The campaign has reached its cap.";
            }
        }

        $agent  = new Agent();
        $agent->setUserAgent($request->input('user_agent', urldecode($request->server('HTTP_USER_AGENT'))));
        $device = $this->getDevice($agent);

        $campaign_targets = $campaign->targets()->active()->get();

        if($campaign_targets->isEmpty()) {
            $report->rate = $campaign->rate;
            $report->network_rate= $campaign->network_rate;
            $report->network_rate_type = $campaign->network_rate_type;
            $redirect_url = $campaign->url;
        } else {
            $target_matched = $this->getTargetMostMatched($campaign_targets, $agent, $geoIP);
            $target = CampaignTarget::find($target_matched);
            $match_target = $this->matchTarget($target, $agent, $geoIP);
            if (($match_target['device'] === true || is_null($match_target['device'])) &&
                ($match_target['country'] === true || is_null($match_target['country'])) &&
                ($match_target['os'] === true || is_null($match_target['os'])) )
            {
                if((float) $target->rate === 0.00)
                    $report->rate = $campaign->rate;
                else
                    $report->rate = $target->rate;

                if((float) $target->network_rate === 0.00)
                    $report->network_rate = $campaign->network_rate;
                    //$report->network_rate_type = $campaign->network_rate_type;
                else
                    $report->network_rate = $target->network_rate;
                    //$report->network_rate_type = $target->network_rate_type;

                $redirect_url = $target->url;
            } else {
                $report->rate = $campaign->rate;
                $report->network_rate= $campaign->network_rate;
                $redirect_url = $campaign->url;
            }
        }

        if( ! $campaign->rates->where('user_id', $user->id)->isEmpty() )
        {
            $report->rate = $campaign->rates->first()->rate;
        }

        $report->user_id     = $user->id;
        $report->campaign_id = $campaign->id;
        $report->status      = 1;
        $report->ip          = $request->getClientIp();
        $report->ref_url     = $request->server('HTTP_REFERER');
        $report->user_agent  = $request->server('HTTP_USER_AGENT');

        if(! is_null($geoIP->city))
            $report->city        = $geoIP->city;
        if(! is_null($geoIP->state))
            $report->state       = $geoIP->state;
        if(! is_null($geoIP->country))
            $report->country = (!is_null( $geoIP->isoCode ) ? $geoIP->isoCode : !is_null( $geoIP->country )) ? $geoIP->country : "Unknown";
        if(! is_null($geoIP->postal_code))
            $report->postal      = $geoIP->postal_code;

        $report->credit_hash = $user->id . $campaign->id . strtotime(\Carbon\Carbon::now()) . Str::random();
        $report->subid1      = $subid1;
        $report->subid2      = $subid2;
        $report->subid3      = $subid3;
        $report->subid4      = $subid4;
        $report->subid5      = $subid5;

        $report->save();

        if(!is_null($request->input('callback', null)))
        {
            $url = urldecode($request->input('callback'));
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url,
                ['query' =>
                    [
                        'credit_hash' => $report->credit_hash,
                        'rate'   => $report->rate,
                        'network_rate'=> $report->network_rate
                    ]
                ]);
            $data = $res->getBody();

        }

        if( str_contains($redirect_url, '{hash}') )
            $redirect_url = str_replace("{hash}", $report->credit_hash, $redirect_url);
        if( str_contains($redirect_url, '{pubid}') )
            $redirect_url = str_replace("{pubid}", $report->user_id, $redirect_url);


            
        session(['ip' => $request->getClientIp()]);
        if ($agent->isMobile() || $agent->isTablet())
        {
            return '
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
                        <meta name="robots" content="noindex,nofollow" />
                        <title>'. $campaign->name .'</title>
                        <link href="'. url('/api/wall/mobile-redirect.css') .'" rel="stylesheet" type="text/css" />
                    </head>
                    <body>
                        <br/>
                        <br/>
                        <h1>LOADING...</h1>
                        <div class="spinner"></div>
                        <h3>If you are not redirected,<br/><br/><a href="'.url($redirect_url).'" class="ir-redirect">Click here</a></h3>
                        <meta http-equiv="refresh" content="2; url='.url($redirect_url).'">
                    </body>
                </html>';
        }
        else
        {
            return '<!DOCTYPE html>
                    <html>
                        <head>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
                            <meta name="robots" content="noindex,nofollow" />
                            <title>'.$campaign->name.'</title>
                            <link href="'. url('/api/wall/mobile-redirect.css') .'" rel="stylesheet" type="text/css" />
                        </head>
                        <body>
                            <br/>
                            <br/>
                            <h1 style="font-size:25px;">Please wait while you are automatically redirected.</h1>
                            <div class="spinner"></div>
                            <h3>If you are not redirected,<br/><br/><a href="'.url($redirect_url).'" class="ir-redirect">Click here</a></h3>
                            <meta http-equiv="refresh" content="2; url='.url($redirect_url).'">
                        
                        </body>
                    </html>';

        }
    }

    private function getDevice(Agent $agent)
    {
        if($agent->isTablet())
            return 'Tablet';
        elseif($agent->isMobile())
            return 'Mobile';
        elseif($agent->isDesktop())
            return 'Desktop';
        elseif($agent->isRobot())
            return 'Robot | ' . $agent->robot();
        else
            return 'Unknown';
    }

    private function matchTarget($campaign_target, Agent $agent, $geoIP)
    {
        if ($this->getDevice($agent) === $campaign_target->device)
            $target['device'] = true;
        elseif (is_null($campaign_target->device) || empty($campaign_target->device))
            $target['device'] = null;
        else
            $target['device'] = false;

        if ($geoIP->country == $campaign_target->country)
            $target['country'] = true;
        elseif (is_null($campaign_target->country) || empty($campaign_target->country))
            $target['country'] = null;
        else
            $target['country'] = false;

        if ($agent->is($campaign_target->operating_system))
            $target['os'] = true;
        elseif (is_null($campaign_target->operating_system) || empty($campaign_target->operating_system))
            $target['os'] = null;
        else
            $target['os'] = false;

        return $target;
    }


    private function getTargetMostMatched($campaign_targets, Agent $agent, $geoIP)
    {
        // Make Sure We have atleast one target for campaign
        if($campaign_targets->isEmpty())
            return null;

        $i = 0;
        foreach($campaign_targets as $campaign_target)
        {
            $targets[$i]['id'] = $campaign_target->id;
            if($this->getDevice($agent) === $campaign_target->device)
                $targets[$i]['device'] = true;
            else
                $targets[$i]['device'] = false;
            if($geoIP->country == $campaign_target->country)
                $targets[$i]['country'] = true;
            else
                $targets[$i]['country'] = false;
            if($agent->is($campaign_target->operating_system))
                $targets[$i]['os'] = true;
            else
                $targets[$i]['os'] = false;
            $i++;
        }

        $i = $count = 0;
        foreach($targets as $target)
        {
            $targeted[$i]['id'] = $target['id'];
            unset($target['id']);
            $targeted[$i]['count'] = count(array_filter($target));

            if($count <= $targeted[$i]['count'])
            {
                $target_most_matched = $targeted[$i]['id'];
                $count = $targeted[$i]['count'];
            }

            $i++;
        }

        return $target_most_matched;
    }


    private function checkIfFromAllowedCountries($campaign_countries, $geoIP)
    {
        foreach($campaign_countries as $allowed_country)
        {
            if($allowed_country->name == $geoIP->country)
                return true;
        }
        return false;
    }


    public static function checkTotalCap(Campaign $campaign) {
        return Report::where('campaign_id', $campaign->id)->where('status', 2)->count() >= $campaign->cap;
    }

    public static function checkDailyCap(Campaign $campaign) {
        return Report::whereDate('created_at', '=', date('Y-m-d'))->where('campaign_id', $campaign->id)->where('status', 2)->count() >= $campaign->cap_daily;
    }
    
}
