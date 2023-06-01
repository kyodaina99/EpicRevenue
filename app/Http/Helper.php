<?php

namespace App\Http;

use App\User;
use App\Models\Report;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignStats as Stats;

class Helper
{
    public static function requestInput(Request $request, $input, $key, $default = null)
    {
        if( isset( $request->input($input)[$key] ) )
            return $request->input($input)[$key];
        else
            return $default;
    }


    public static function updateCash(User $user, Report $report)
    {

        if( ! is_null($user->referral_id))
        {
            $referral_user = User::where('id' ,$user->referral_id)->with('balance', 'balance.histories')->first();

            if(! is_null($referral_user))
                self::updateReferral($user, $report, $referral_user);
        }
        
        $campaign_id = $report->campaign_id;
        
        // Retrieve the campaign by campaign_id using the Campaigns model
        $campaign = Campaign::find($campaign_id);

        //if ($report->network_rate_type == 4) {
        // check if its a percentage offer or if network_payout is null   
        if ($report->network_rate_type == 4 || ($report->network_payout !== null)) {
            
            // Convert $report->rate to an integer
            $rate = (int) $campaign->rate_percentage;

            // Calculate the amount you want to keep. This is done by multiplying the network payout by the desired rate.
            $network_amount_kept = $report->network_payout * ($rate / 100);

            // Calculate the amount to be paid to the affiliate.
            $affiliate_amount = $report->network_payout - $network_amount_kept;

            $cash = $affiliate_amount;

            echo "Network payout: $report->network_payout<br>"; // debug output
            echo "Percentage to keep: $rate<br>"; // debug output
            echo "Amount kept: $network_amount_kept<br>"; // debug output
            echo "Amount to affiliate: $affiliate_amount<br>"; // debug output

        } 
        else 
        {
            $cash = $report->rate;
        }

        $history = UserBalanceHistory::create([
            'user_balance_id' => $user->balance->id,
            'type'            => 'cash',
            'operation'       => 'add',
            'amount'          => $cash
        ]);

        echo "Campaign ID: $campaign_id<br>"; // debug output
        echo "Campaign %: $campaign->rate_percentage<br>"; // debug output
        
        echo "Amount inserted: $history->amount<br>"; // debug output

        $user->balance->cash = floatval($user->balance->cash) + $cash;
        $user->push();

        return true;
    }


    public static function removeCash(User $user, Report $report)
    {

        if( ! is_null($user->referral_id))
        {
            $referral_user = User::where('id' ,$user->referral_id)->with('balance', 'balance.histories')->first();

            if(! is_null($referral_user))
                self::removeReferral($user, $report, $referral_user);
        }

        $campaign_id = $report->campaign_id;
    
        // Retrieve the campaign by campaign_id using the Campaigns model
        $campaign = Campaign::find($campaign_id);

        //if ($report->network_rate_type == 4) {
        // check if its a percentage offer or if network_payout is null   
        if ($report->network_rate_type == 4 || ($report->network_payout !== null)) {
            
            // Convert $report->rate to an integer
            $rate = (int) $campaign->rate_percentage;

            // Calculate the amount you want to keep. This is done by multiplying the network payout by the desired rate.
            $network_amount_kept = $report->network_payout * ($rate / 100);

            // Calculate the amount to be paid to the affiliate.
            $affiliate_amount = $report->network_payout - $network_amount_kept;

            $cash = $affiliate_amount;

        } 
        else 
        {
            $cash = $report->rate;
        }

        $history = UserBalanceHistory::where('user_balance_id', (int) $user->balance->id)
                ->where('type', 'cash')
                ->where('operation', 'add')
                ->where('amount', $cash)
                ->first();
        if(!is_null($history))
            $history->forceDelete();

        $user->balance->cash = floatval($user->balance->cash) - $cash;
        $user->push();

        return true;
    }

    public static function updateReferral(User $user, Report $report, User $referral_user)
    {
        $campaign_id = $report->campaign_id;
    
        // Retrieve the campaign by campaign_id using the Campaigns model
        $campaign = Campaign::find($campaign_id);

        //if ($report->network_rate_type == 4) {
        // check if its a percentage offer or if network_payout is null   
        if ($report->network_rate_type == 4 || ($report->network_payout !== null)) {
            
            // Convert $report->rate to an integer
            $rate = (int) $campaign->rate_percentage;

            // Calculate the amount you want to keep. This is done by multiplying the network payout by the desired rate.
            $network_amount_kept = $report->network_payout * ($rate / 100);

            // Calculate the amount to be paid to the affiliate.
            $affiliate_amount = $report->network_payout - $network_amount_kept;

            $cash = $affiliate_amount;

        } 
        else 
        {
            $cash = $report->rate;
        }

        // Update referral earnings if has referral_id
        $ref_percent = 3;
        $referral = ($ref_percent / 100) * $cash;

        $array = array(
            'user_balance_id' => $referral_user->balance->id,
            'referrer_id'     => $user->id,
            'type'            => 'referral',
            'operation'       => 'add',
            'amount'          => $referral
        );

        $history = UserBalanceHistory::create($array);

        $referral_user->balance->referral = $referral_user->balance->referral + $referral;
        $referral_user->push();

        return true;
    }

    public static function removeReferral(User $user, Report $report, User $referral_user)
    {
        $campaign_id = $report->campaign_id;
    
        // Retrieve the campaign by campaign_id using the Campaigns model
        $campaign = Campaign::find($campaign_id);

        //if ($report->network_rate_type == 4) {
        // check if its a percentage offer or if network_payout is null   
        if ($report->network_rate_type == 4 || ($report->network_payout !== null)) {
            
            // Convert $report->rate to an integer
            $rate = (int) $campaign->rate_percentage;

            // Calculate the amount you want to keep. This is done by multiplying the network payout by the desired rate.
            $network_amount_kept = $report->network_payout * ($rate / 100);

            // Calculate the amount to be paid to the affiliate.
            $affiliate_amount = $report->network_payout - $network_amount_kept;

            $cash = $affiliate_amount;

        } 
        else 
        {
            $cash = $report->rate;
        }

        // Update referral earnings if has referral_id
        $ref_percent = 3;
        $referral = ($ref_percent / 100) * $cash;

        $array = array(
            'user_balance_id' => $referral_user->balance->id,
            'referrer_id'     => $user->id,
            'type'            => 'referral',
            'operation'       => 'add',
            'amount'          => $referral
        );

        $history = UserBalanceHistory::where('user_balance_id', (int) $user->balance->id)
            ->where('referrer_id', (int) $user->id)
            ->where('type', 'referral')
            ->where('operation', 'add')
            ->where('amount', $referral)
            ->first();
        if(!is_null($history))
            $history->forceDelete();

        if($referral_user->balance->referral >= 0)
            $referral_user->balance->referral = $referral_user->balance->referral - $referral;
        else
            $referral_user->balance->referral = 0;

        $referral_user->push();

        return true;
    }

    public function updatePoints($user_id, $amount)
    {
        $user = User::findOrFail($user_id);
        return $user;
    }


    public static function today_clicks()
    {
        $date = Carbon::now();
        return Report::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', array($date->startOfDay()->toDateTimeString(), $date->endOfDay()->toDateTimeString()))
            // ->where('status', 1)
            ->count();
    }

    public static function today_leads()
    {
        $date = Carbon::now();
        return Report::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', array($date->startOfDay()->toDateTimeString(), $date->endOfDay()->toDateTimeString()))
            ->where('status', 2)
            ->count();
    }

    public static function earnings_today()
    {
        $date = Carbon::now();
        return Report::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', array($date->startOfDay()->toDateTimeString(), $date->endOfDay()->toDateTimeString()))
            ->where('status', 2)
            ->sum('rate');
    }

    public static function earnings_monthly()
    {
        $date = Carbon::now();
        return Report::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', array($date->startOfMonth()->toDateTimeString(), $date->endOfMonth()->toDateTimeString()))
            ->where('status', 2)
            ->sum('rate');
    }

    public static function earnings_yearly()
    {
        $date = Carbon::now();
        return Report::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', array($date->startOfYear()->toDateTimeString(), $date->endOfYear()->toDateTimeString()))
            ->where('status', 2)
            ->sum('rate');
    }


    public static function earnings_chart()
    {
        $start = Carbon::now()->subDays(7)->toDateTimeString();
        $end = Carbon::now()->toDateTimeString();
        $earnings = Report::where('user_id', auth()->user()->id)
            ->where('status', 2)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $earnings = $earnings->sortBy(function ($item, $key) {
            return date("M d", strtotime($item['created_at']));
        })->groupBy(function ($item, $key) {
            return date("M d", strtotime($item['created_at']));
        });


        $chart_data = array();
        $i = 0;
        foreach ($earnings as $date => $e)
        {
            $chart_data[$i]['date'] = $date;
            $chart_data[$i]['value'] = $e->sum('rate');
            $i++;
        }

        if(empty($chart_data))
        {
            $chart_data[0]['date'] = date("M d");
            $chart_data[0]['value'] = 0;
        }

        return $chart_data;
    }


    public static function top_campaigns( Carbon $date )
    {
      $campaigns = Stats::where( 'date', '>', $date->subDays(7)->toDateString() )
                    ->groupBy('campaign_id')
                    ->orderBy('cr', 'desc')
                    ->selectRaw('*,sum(cr) as cr_sum')
                    ->with('campaign')
                    ->get()
                    ->pluck("campaign", "campaign_id");

        foreach($campaigns as $campaign)
        {
            if(isset($campaign->incent) && ($campaign->incent == 'yes' || $campaign->active == 'no'))
                $campaigns->forget($campaign->id);
        }

        return $campaigns->take(5);
    }
}
