<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Models\Report;
use App\Models\CampaignStats as Stats;
use Carbon\Carbon;

class CampaignStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron to sync daily campaigns stats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->lastDay();
    }


    private function lastDay()
    {
        $date = Carbon::now()->subDay();

        $date = Carbon::parse( Carbon::now()->subDay()->toDateString() );
        $campaigns = Campaign::all();

        $bar = $this->output->createProgressBar(count($campaigns));    

        foreach($campaigns as $campaign)
        {
            $stats = Stats::where('campaign_id', (int) $campaign->id)->where('date', $date->toDateTimeString())->first();
            if(is_null($stats))
                $stats = new Stats();

            $stats->campaign_id = (int) $campaign->id;
            $stats->leads = (int) Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->count();
            $stats->clicks = (int) Report::where('campaign_id', (int) $campaign->id)->date($date)->count();
            $stats->revenue = (int) ("0" + Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->sum('network_rate') );
            $stats->profit = (int) ("0" + $stats->revenue - Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->sum('rate') );
            $stats->date = $date->toDateString();

            $q = ($stats->clicks);
            if($q == 0)
                $q = 1;
            $stats->cr = ($stats->leads / $q)  * 100;
            $stats->save();

            $bar->advance();            
        }

        $bar->finish();
    }


    private function all()
    {
        $bar = $this->output->createProgressBar(800);    
        for($i = 800; $i >= 1; $i--)
        {
            $date = Carbon::parse( Carbon::now()->subDays($i - 1)->toDateString() );

            $campaigns = Campaign::all();

            foreach($campaigns as $campaign)
            {
                $stats = Stats::where('campaign_id', (int) $campaign->id)->where('date', $date->toDateTimeString())->first();
                if(is_null($stats))
                    $stats = new Stats();

                $stats->campaign_id = (int) $campaign->id;
                $stats->leads = (int) Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->count();
                $stats->clicks = (int) Report::where('campaign_id', (int) $campaign->id)->date($date)->count();
                $stats->revenue = (int) ("0" + Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->sum('network_rate') );
                $stats->profit = (int) ("0" + $stats->revenue - Report::where('campaign_id', (int) $campaign->id)->date($date)->lead()->sum('rate') );
                $stats->date = $date->toDateString();

                $q = ($stats->clicks);
                if($q == 0)
                    $q = 1;
                $stats->cr = ($stats->leads / $q)  * 100;
                $stats->save();
                
            }

            $bar->advance();

        }

        $bar->finish();
    }
}
