<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\Report;
use App\Models\UserApi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Jenssegers\Agent\Agent;

class ApiController extends Controller
{
    public function key($id = 1)
    {
        $api = UserApi::where('user_id', (int) $id)->first();
        if(! is_null($api))
            return $api->key;

        $api = UserApi::where('user_id', 1)->first();
        return $api->key;
    }

    public function checkerJs()
    {
        $js = '
            $("a.ir-app-box").click(function () {
            var thisattr = $(this).attr("data-subid2");
            var leadsneeded = $(this).attr("data-ln");
            var redirectURI = $(this).attr("redirect-url");
            if ((thisattr) && leadsneeded <= 1) {
                offerClicked(thisattr);
            }
            {
               showLoader(thisattr);
            }
            });
            var clickedInt = {};
            function offerClicked(timerid) {
                hideOffers();
                clickedInt.timerid = setInterval(function () {
                    runCheck(timerid);
                }, 3000);
            }
            var status;
            function runCheck(timerid) {
                $.post("'.url('/api/wall/checker').'", {
                        hash: timerid
                    },
                    function (data) {
                        var status = $.parseJSON(data);
                        console.log(status);
                        if (status.status == 2) {
                            /*
                            if ((leadsneeded > 1))
                            {

                            }
                            else
                            {
                                window.location=status.redirect;
                            }
                            */
                            // window.location=status.redirect;
                            clearInterval(clickedInt.timerid);
                            hideOffersCompletely();

                            return false;
                        } else if (status.status == 0) {
                            clearInterval(clickedInt.timerid);
                            showOffers();
                        }
                    });
            }
            function showLoader(timerid) {
                $(".ir-app-loader-multiple").show();
                clickedInt.timerid = setInterval(function () {
                    runCheck(timerid);
                }, 3000);
            }
            function hideOffers() {
                $(".ir-app-box").hide();
                $(".ir-app-loader").show();
            }
            $(".ir-show-offers-link").click(function(){
                $(".ir-app-box").show();
                $(".ir-app-loader").hide();
            });'
        ;

        $response = Response::make($js, 200);
        $response->header('Content-Type', "text/javascript");
        return $response;
    }

    public function wallCss()
    {
        $css = "@import url('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800');
                .regular, .ir-app-name {
                    font-family: 'Open Sans', sans-serif;
                    font-weight: 400;
                }
                .semibold, .ir-amount-complete  {
                        font-family: 'Open Sans', sans-serif;
                    font-weight: 700;
                }
                .light, .ir-offers-needed .ir-small {
                        font-family: 'Open Sans', sans-serif;
                    font-weight: 300;
                }

                /*Containers*/
                .ir-apps-holder {
                        float: left;
                        width: 100%;
                        background-color: #fff;
                }

                .ir-alert-error {
                        color: #F00;
                    }
                .ir-alert-red {
                        font-size: 12px;
                  text-align: center;
                  float: left;
                  width: 100%;
                  background: #fde5e5;
                  font-weight: bold;
                  padding: 10px;
                  box-sizing: border-box;
                  border: 1px solid #e9cece;
                  color: #a94442;
                  margin-bottom: 10px;
                }
                /*the apps*/
                .ir-app-box {
                        border-top: 1px solid #eee;
                  border-left: 1px solid #eee;
                  border-right: 1px solid #eee;
                  display: block;
                  float: left;
                  width: 100%;
                  box-sizing: border-box;
                  text-align: center;
                  padding: 10px !important;
                  text-decoration: none !important;
                }
                .ir-app-box:last-child {
                        border-bottom: 1px solid #eee;
                }
                .ir-app-icon {
                        float: left;
                        margin-right: 10px;
                }
                .ir-app-icon .blur {
                        background-color: #000;
                  border-radius: 12px;
                  overflow: hidden;
                }
                .ir-app-name {
                        color: #000;
                        text-decoration: none;
                  padding: 0;
                  margin: 5px 0;
                  float: left;
                }
                .ir-app-box img {
                        border: 1px solid #eee;
                  border-radius: 12px;
                  max-width: 55px;
                }
                .ir-app-box img.blur {
                        -moz-filter: blur(5px); -o-filter: blur(5px); -ms-filter: blur(5px); filter: blur(5px);
                  -webkit-filter: blur(8px);
                  opacity: 0.8;
                }

                /*Single loader*/
                .ir-app-loader {
                        float: left;
                        width: 100%;
                        text-align: center;
                }
                .ir-offer-spinner {
                        float: left;
                        width: 100%;
                        text-align: center;
                }
                .ir-offer-spinner img {
                        display: block;
                        margin: 0 auto;
                }

                /*Multiple loader*/
                .ir-app-loader-fixed {
                        float: left;
                        width: 100%;
                        padding: 35px 10px;
                  border: solid 1px rgba(178,178,178,.25);
                  background: #fff;
                  text-align: center;
                  box-sizing: border-box;
                }
                .ir-app-loader-multiple .sqaureloader {
                        height: 15px;
                  width: 100%;
                  overflow: hidden;
                  background: url('http://498bbb120b9a94c11576-05fe5b6203e21d94ca5e0da32c9e5b21.r37.cf1.rackcdn.com/theme1/animated_progress.gif') repeat-x;
                  -moz-opacity: 0.25;
                  -khtml-opacity: 0.25;
                  -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=25);
                  filter: progid:DXImageTransform.Microsoft.Alpha(opacity=25);
                  filter: alpha(opacity=25);
                  background-color: #A1C969;
                  border: 1px solid #000;
                  box-sizing: border-box;
                }
                .ir-offers-needed {
                        color: #000;
                    }
                .ir-offers-needed .ir-small {
                        font-size: 10px;
                  color: #030303;
                  margin-bottom: 12px;
                  display: block;
                }
                .ir-amount-complete {
                        margin-bottom: 8px;
                  text-transform: uppercase;
                  color: #4F4C4C;
                }
                .ir-amount-complete b {
                        background-color: #A1C969;
                  color: #fff;
                  padding: 0px 10px;
                  border-radius: 20px;
                  border: 1px solid #88B050;
                  font-size: 14px;
                }";
        $response = Response::make($css, 200);
        $response->header('Content-Type', "text/css");
        return $response;
    }

    public function mobileCss()
    {
        $css = "@import url(" . "//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" . ");
            .regular,body {
                font-family: 'Open Sans', sans-serif;
                font-weight: 500;
            }
            .semibold {
                    font-family: 'Open Sans', sans-serif;
                font-weight: 700;
            }
            .light {
                    font-family: 'Open Sans', sans-serif;
                font-weight: 300;
            }
            .regular-light {
                    font-family: 'Open Sans', sans-serif;
                font-weight: 300;
            }
            html {
                    height: 100%;
                    overflow: hidden;
                }

            body {
                background-color: #5BA4F7;
              color: #fff;
              font: 18px " . "Helvetica Neue" .", Arial, Helvetica, Geneva, sans-serif;
              line-height: 1.5em;
              text-align: center;
              height: 100%;
              position: relative;
              overflow: scroll;

              -webkit-transition: background-color 0.6s ease-in-out 0s;
              transition: background-color 0.6s ease-in-out 0s;
            }

            a {
                    color: #000;
                }
            h1 {
                    line-height: 40px;
              margin: 0;
            }
            .spinner {
                width: 60px;
                height: 60px;
                background-color: #fff;

                margin: 100px auto;
                -webkit-animation: rotateplane 1.2s infinite ease-in-out;
                animation: rotateplane 1.2s infinite ease-in-out;
            }

            @-webkit-keyframes rotateplane {
                0% { -webkit-transform: perspective(120px) }
                50% { -webkit-transform: perspective(120px) rotateY(180deg) }
                100% { -webkit-transform: perspective(120px) rotateY(180deg)  rotateX(180deg) }
            }

            @keyframes rotateplane {
                    0% {
                        transform: perspective(120px) rotateX(0deg) rotateY(0deg);
                -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg)
              } 50% {
                        transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg);
                -webkit-transform: perspective(120px) rotateX(-180.1deg) rotateY(0deg)
              } 100% {
                        transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
                -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-179.9deg);
              }
            }
            .ir-redirect {
                    background: #fff;
                    padding: 10px 20px;
              margin-top: 5px;
              display: inline-block;
              text-decoration: none;
              text-transform: uppercase;
              border-radius: 35px;
              font-size: 20px;
            }
            ";
        $response = Response::make($css, 200);
        $response->header('Content-Type', "text/css");
        return $response;
    }

    public function campaignCheck(Request $request)
    {

    }

    public function checker(Request $request)
    {
//        header("Access-Control-Allow-Origin: *");

        if($request->input('sub_id_1') === 'tunebin') {
            $ir_key = $request->input('ir_key', 0);
            $ir_secret = $request->input('ir_secret', 0);

            $reports = Report::where('subid1', 'tunebin')
                ->where('subid2', $request->input('sub_id_2', ''))
                ->where('subid3', $request->input('sub_id_3', ''))
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($reports as $report) {
                if((int) $report->status === 2) {
                    return array("status" => 1);
                }
            }

            return array("status" => 0);

        } else {

            $ip = $request->getClientIp();

            $credit_hash = $request->input('hash');

            if (! empty($credit_hash) || ! is_null($credit_hash))
            {
//            $report = Report::where('subid2', 'mobilewall_' . $credit_hash)->first();
                $report = Report::where('credit_hash', $credit_hash)->first();
                if (! is_null($report))
                {
                    $status = (int) $report->status;
                    $subid3 = $report->subid3;
                    $clickerip = $report->ip;

                    if($ip == $clickerip)
                    {
                        if ($status === 1)
                        {
                            return array("status" => 1);
                        }
                        elseif ($status === 2)
                        {
                            return array("status" => 2, "redirect" => $subid3);
                        }
                    }
                    else
                    {
                        return array("status" => 0);
                    }
                }
                else
                {
                    return array("status" => 1);
                }

            }

            return array("status" => 0);
        }
    }


    public function wallJson(Request $request, $key)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');

        $target_country = (int) $request->input('target_country', 1);
        $target_device = (int) $request->input('target_device', 1);
        $target_os = (int) $request->input('target_os', 1);

        $url = $request->input('url');
        $leads_needed = (int) $request->input('ln', null);
        $agent  = new Agent();
        $matchedTargets = $unMatchedTargets = $withNoTargets = array();
        $geoIP = \GeoIP::getLocation($request->getClientIp());

        $api = UserApi::where('key', $key)->first();
        if(is_null($api))
        {
            return ['status' => '400', 'error' => 'API Key not set or invalid.'];
        }
        else
        {
            $campaigns = Campaign::where('active', 'yes')
                ->where('incent', 'yes')
                ->groupBy('campaigns.id')
                ->with('targets', 'category')
                ->get();

            foreach ($campaigns as $campaign) {
                $campaign->count = $campaign->reports()->sum('status');
            }
            $campaigns = $campaigns->sortByDesc('count');

            foreach($campaigns as $key => $campaign)
            {
                if($campaign->activeTargets->isEmpty()) {
                    $withNoTargets[] = (int) $campaign->id;
                } else {
                    $target_matched = $this->getTargetMostMatched($campaign->activeTargets, $agent, $geoIP);
                    $target = $campaign->targets()->where('id', (int) $target_matched)->first();
                    $match_target = $this->matchTarget($target, $agent, $geoIP, $target_device, $target_country, $target_os);
                    if (($match_target['device'] === true || is_null($match_target['device'])) &&
                        ($match_target['country'] === true || is_null($match_target['country'])) &&
                        ($match_target['os'] === true || is_null($match_target['os'])) )
                    {
                        $matchedTargets[] = (int) $target->campaign_id;
                        $campaign->android = $campaign->ios = false;
                        foreach($campaign->activeTargets as $activeTarget)
                        {
                            if( $activeTarget->operating_system === 'AndroidOS')
                                $campaign->android = true;
                            if( strtolower($activeTarget->operating_system) === 'ios')
                                $campaign->ios = true;
                        }
                    } else {
//                        $unMatchedTargets[] = (int) $campaign->id;
                        $campaigns->forget($key);
                    }
                }
                unset($campaign->activeTargets);
                unset($campaign->targets);
                $campaign->featured_img = url('/campaign/image/' . $campaign->id);
            }

            if($request->input('mobile', 0)) {
                $campaigns = $campaigns->where('mobile', 'yes');
            } else {
                if ( $agent->isMobile() || $agent->isTablet())
                    $campaigns = $campaigns->where('mobile', 'yes');
                else
                    $campaigns = $campaigns->where('mobile', 'no');
            }


            $keys = array();
            foreach ($campaigns as $key => $campaign) {
                if( ! $this->checkIfFromAllowedCountries($campaign->countries, $geoIP, $target_country) )
                {
                    $keys[] = $key;
                }
                unset($campaign->countries);
            }
            $campaigns->forget($keys);

            foreach((array) $geoIP as $index => $geo){
                $location = (array) $geo;
            }
            $data['user_id'] = (int) $api->user_id;
            $data['campaigns'] = $campaigns;
            $data['url'] = $url;
            $data['location'] = (array) $location;
            $data['leads_needed'] = $leads_needed;
            $data['device'] = $this->getDevice($agent);
        }

        return $data;
    }

    public function wall(Request $request, $key)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
       
        $url = $request->input('url');
        $leads_needed = (int) $request->input('ln', 1);
        $agent  = new Agent();
        $matchedTargets = $unMatchedTargets = $withNoTargets = array();
        $geoIP = \GeoIP::getLocation($request->getClientIp());

        $string = '<link href="'.url('/api/wall/IR-mobile-wall.css').'" rel="stylesheet" type="text/css"/>';
        $string .= '<div class="ir-apps-container">'; // Start Container
        $api = UserApi::where('key', $key)->first();
        if(is_null($api))
        {
            $string .= '<div class="ir-alert-error">API Key not set or invalid.</div>';
        }
        else
        {
            $campaigns = Campaign::where('active', 'yes')
                ->where('incent', 'yes')
                ->leftJoin('reports', 'campaigns.id', '=', 'reports.campaign_id')
                ->selectRaw('campaigns.*, sum(reports.status) as count')
                ->groupBy('campaigns.id')
                ->orderBy('count', 'desc')
                ->with('targets')
                ->get();

            foreach($campaigns as $key => $campaign)
            {
//                if((float) $campaign->cap !== 0)
//                {
//                    // Check if total cap or daily cap reached
//                    if($this->checkTotalCap($campaign) || $this->checkDailyCap($campaign))
//                    {
//                        $campaign->active = 'no';
//                        $campaign->save();
//                        $campaigns->forget($key);
//                    }
//                }

                if($campaign->activeTargets->isEmpty()) {
                    $withNoTargets[] = (int) $campaign->id;
                } else {
                    $target_matched = $this->getTargetMostMatched($campaign->activeTargets, $agent,  $geoIP);
                    $target = $campaign->targets()->where('id', (int) $target_matched)->first();
                    $match_target = $this->matchTarget($target, $agent, $geoIP);
                    if (($match_target['device'] === true || is_null($match_target['device'])) &&
                        ($match_target['country'] === true || is_null($match_target['country'])) &&
                        ($match_target['os'] === true || is_null($match_target['os'])) )
                    {
                        $matchedTargets[] = (int) $target->campaign_id;
                    } else {
//                        $unMatchedTargets[] = (int) $campaign->id;
                        $campaigns->forget($key);
                    }
                }
            }

            if ( $agent->isMobile() || $agent->isTablet())
            {
                $campaigns = $campaigns->where('mobile', 'yes');
                $string .= '<div class="ir-alert-red">"Download" & "OPEN" for 30 seconds '.$leads_needed.' of the apps below that you have never downloaded before to continue.</div>';
            }
            else
            {
                $campaigns = $campaigns->where('mobile', 'no');
                $string .= '<div class="ir-alert-red">You have triggered our bot prevention, Complete '. $leads_needed .' of our sponsors surveys below to continue.</div>';
            }

            $string .= '<div class="ir-apps-holder">';

            $keys = array();
            foreach ($campaigns as $key => $campaign) {
                if( ! $this->checkIfFromAllowedCountries($campaign->countries, $geoIP) )
                {
                    $keys[] = $key;
                }
            }
            $campaigns->forget($keys);

            if($campaigns->isEmpty()){
                $string .= '<div class="ir-alert-error">There are no campaigns at this time.</div>';
            } else {
                foreach ($campaigns->take(6) as $campaign)
                {
                    $campaign_url = url("/track/".$campaign->id."/".$api->user_id);

                    $string .= '<a href="'.$campaign_url.'" class="ir-app-box" target="_blank" data-ln="'.$leads_needed.'" redirect-url="'.$url.'" data-subid2="'.$campaign->subid2.'" id="'.$campaign->subid2.'">';
                    $string .= '<div class="ir-app-icon"><img src="'.url('/campaign/image/' . $campaign->id).'"></div>';
                    $string .= '<div class="ir-app-name">'.$campaign->name.'</div>';
                    $string .= '</a>';
                }
            }

            $string .= '</div>';

            if ( $agent->isMobile() )
            {
                if(isset($leads_needed) && $leads_needed > 1)
                {
                    $string .= '<div class="ir-app-loader-fixed">';
                    $string .= '<div class="ir-offers-needed"><div class="ir-amount-complete">App downloads needed <b>'.$leads_needed.'</b></div><span class="ir-small">You will be redirected after you "Download" & "OPEN" '.$leads_needed.' apps</span></div>';
                    $string .= '<div class="ir-app-loader-multiple" style="display:none;"><div class="sqaureloader"></div></div>';
                    $string .= '</div>';
                }
                elseif ($leads_needed <= 1)
                {
                    $string .= '<div class="ir-app-loader" style="display:none;">';
                    $string .= '<div class="ir-offer-spinner"><img src="http://epicrevenue.com/assets/img/wheel-throb.gif"/> Checking for app download...</div> <div class="ir-show-offers"><a href="#" class="ir-show-offers-link">If this page doesnt redirect after downloading and launching an app, Click here to try another.</a></div>';
                    $string .= '</div>';
                }
                else
                {
                    //Show nothing
                }

                // Check and show checker
                $string .= '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>';
                $string .= '<script type="text/javascript" language="Javascript" src="'.url('/api/wall/checker.js').'"></script>';
            }
            else
            {
                if(isset($leads_needed) && $leads_needed > 1)
                {
                    $string .= '<div class="ir-app-loader-fixed">';
                    $string .= '<div class="ir-offers-needed"><div class="ir-amount-complete">Surveys completion needed <b>'.$leads_needed.'</b></div><span class="ir-small">You will be redirected after completing '.$leads_needed.' surveys.</span></div>';
                    $string .= '<div class="ir-app-loader-multiple" style="display:none;"><div class="sqaureloader"></div></div>';
                    $string .= '</div>';
                }
                elseif ($leads_needed <= 1)
                {
                    $string .= '<div class="ir-app-loader" style="display:none;">';
                    $string .= '<div class="ir-offer-spinner"><img src="http://epicrevenue.com/assets/img/wheel-throb.gif"/> Checking for completion...</div> <div class="ir-show-offers"><a href="#" class="ir-show-offers-link">If this page doesnt redirect after completion of survey, Click here to try another.</a></div>';
                    $string .= '</div>';
                }
                else
                {
                    //Show nothing
                }

                // Check and show checker
                $string .= '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>';
                $string .= '<script type="text/javascript" language="Javascript" src="'.url('/api/wall/checker.js').'"></script>';
            }
        }

        $string .= '</div>'; // End container
        $response = Response::make("document.write('" . addslashes( $string ) . "')", 200);
        $response->header('Content-Type', "text/javascript");
        return $response;
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

    private function matchTarget($campaign_target, Agent $agent, $geoIP, $target_device = true, $target_country = true, $target_os = true)
    {
        if ($this->getDevice($agent) === $campaign_target->device || !$target_device)
            $target['device'] = true;
        elseif (is_null($campaign_target->device) || empty($campaign_target->device))
            $target['device'] = null;
        else
            $target['device'] = false;

        if ($geoIP->country == $campaign_target->country || !$target_country)
            $target['country'] = true;
        elseif (is_null($campaign_target->country) || empty($campaign_target->country))
            $target['country'] = null;
        else
            $target['country'] = false;

        if ($agent->is($campaign_target->operating_system) || !$target_os)
            $target['os'] = true;
        elseif (is_null($campaign_target->operating_system) || empty($campaign_target->operating_system))
            $target['os'] = null;
        else
            $target['os'] = false;

        return $target;
    }


    private function getTargetMostMatched($campaign_targets, Agent $agent, $geoIP, $target_device = true, $target_country = true, $target_os = true)
    {
        // Make Sure We have atleast one target for campaign
        if($campaign_targets->isEmpty())
            return null;

        $i = 0;
        foreach($campaign_targets as $campaign_target)
        {
            $targets[$i]['id'] = $campaign_target->id;
            if($this->getDevice($agent) === $campaign_target->device || !$target_device)
                $targets[$i]['device'] = true;
            else
                $targets[$i]['device'] = false;
            if($geoIP->country == $campaign_target->country || !$target_country)
                $targets[$i]['country'] = true;
            else
                $targets[$i]['country'] = false;
            if($agent->is($campaign_target->operating_system) || !$target_os)
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
                $target_most_matched = (int) $targeted[$i]['id'];
                $count = $targeted[$i]['count'];
            }

            $i++;
        }

        return $target_most_matched;
    }


    private function checkIfFromAllowedCountries($campaign_countries, $geoIP, $target_country = true)
    {
        foreach($campaign_countries as $allowed_country)
        {
            if($target_country) {
                if($allowed_country->name === $geoIP->country)
                    return true;
            } else {
                return true;
            }
        }
        return false;
    }

    /*
    public static function checkTotalCap(Campaign $campaign)
    {
        $total_cap = 0;
        foreach($campaign->reports->where('status', 2) as $report)
        {
            $total_cap = $total_cap + $report->rate;
        }

        if($campaign->cap <= $total_cap)
            return true;

        return false;
    }

    public static function checkDailyCap(Campaign $campaign)
    {
        $cap_daily = 0;
        foreach($campaign->reports->where('status', 2) as $report)
        {
            if($report->created_at->isToday())
            {
                $cap_daily = $cap_daily + $report->rate;
            }
        }

        if($campaign->cap_daily <= $cap_daily)
            return true;

        return false;
    }
    */
    public static function checkTotalCap(Campaign $campaign) {
        return Report::where('campaign_id', $campaign->id)->where('status', 2)->count() >= $campaign->cap;
    }

    public static function checkDailyCap(Campaign $campaign) {
        return Report::whereDate('created_at', '=', date('Y-m-d'))->where('campaign_id', $campaign->id)->where('status', 2)->count() >= $campaign->cap_daily;
    }
}
