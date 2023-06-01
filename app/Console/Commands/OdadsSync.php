<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignsCategory;
use App\Models\CampaignTarget;
use App\Models\Country;
use App\Models\Postback;
use Illuminate\Console\Command;

class OdadsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ogads:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync campaigns with ogads';

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
        $category = CampaignsCategory::where('name', 'Mobile Apps')->first();
        $network = Postback::where('name', 'ogmobi')->first();

        $client = new \GuzzleHttp\Client(['base_uri' => 'https://mobverify.com' ]);
        $response = $client->request('GET', '/api/v1/?affiliateid=10148&ctype=1');

        $allOffers = collect(json_decode($response->getBody())->offers);

        $campaignsFind = collect();
        $targetsFind = collect();
        $offersFind = collect();
        foreach ($allOffers as $offer)
        {
            $allowedCountries = $this->translateCountriesFromISO2(explode(',', $offer->country));
            $targets = CampaignTarget::where('network_campaign_id', $offer->offerid)->get();
            if (($targets->isNotEmpty())) {
                foreach ($targets as $target) {
                    $campaign = $target->campaign;
                    if ($campaignsFind->where('id', $campaign->id)->isEmpty()) {
                        $campaign->countries()->detach();
                        $campaignsFind->push($campaign);
                    }
                    $offersFind->push($offer);
                    $targetsFind->push($target);

                    $target->url = $offer->link . "&" . $network->ch_slot . "={hash}";
                    $target->rate = ($offer->payout / 100) * 70;
                    $target->network_rate = $offer->payout;

                    $country = Country::where('code', $target->country)->first();

                    $d = "Desktop";
                    if($target->device == 'iPhone' || $target->device == 'Android')
                        $d = "Mobile";
                    elseif ($target->device == 'iPad')
                        $d = "Tablet";
                    elseif($target->device == "Desktop")
                        $d = "Desktop";

                    $os = null;
                    if($target->device == 'iPhone' || $target->device == 'iPad')
                        $os = 'iOS';
                    elseif ($target->device == 'Android')
                        $os = 'AndroidOS';

                    if (strpos($offer->country, $country->iso2) !== false && strpos($target->device, $d) !== false && strpos($target->operating_system, $os) !== false) {
                        $target->active = 'yes';
                        $target->save();
                    } else {
                        $target->delete();

                        $devices = explode(',',$offer->device);

                        CampaignTarget::where('network_campaign_id', $offer->offerid)->delete();
                        foreach ($allowedCountries as $country)
                        {
                            foreach ($devices as $device)
                            {
                                if(!is_null($device))
                                {
                                    $cc = new CampaignTarget();
                                    $cc->campaign_id      = $campaign->id;

                                    if($device == 'iPhone' || $device == 'iPad')
                                        $cc->operating_system = 'iOS';
                                    elseif ($device == 'Android')
                                        $cc->operating_system = 'AndroidOS';

                                    $cc->rate             = ($offer->payout / 100) * 70;
                                    $cc->network_rate     = $offer->payout;
                                    $cc->url              = $offer->link . "&".$network->ch_slot . "={hash}";
                                    $cc->country          = $country->code;
                                    $cc->network_campaign_id = $offer->offerid;

                                    if($device == 'iPhone' || $device == 'Android')
                                        $cc->device = "Mobile";
                                    elseif ($device == 'iPad')
                                        $cc->device = "Tablet";
                                    elseif($device == "Desktop")
                                        $cc->device = "Desktop";

                                    $cc->active    = 'yes';
                                    $cc->save();
                                    $targetsFind->push($cc);
                                }
                            }
                        }

                        if (isset($campaign))
                            $campaign->countries()->attach($allowedCountries->pluck('id')->toArray());
                        break;
                    }
                }

                if (isset($campaign))
                    $campaign->countries()->attach($allowedCountries->pluck('id')->toArray());
            }
        }

        foreach ($network->campaigns()->get() as $c)
        {
            foreach ($c->targets()->get() as $t)
            {
                if($targetsFind->where('id', $t->id)->isEmpty())
                {
                    $c->countries()->detach([Country::where('code', $t->country)->first()->id]);
                    $t->active = 'no';
                    $t->save();
                }
            }
        }

        foreach ($network->campaigns()->whereNotIn('id', $campaignsFind->pluck('id'))->get() as $campaign) {
            $campaign->active = 'no';
            $campaign->save();
        }
        foreach ($network->campaigns()->whereIn('id', $campaignsFind->pluck('id'))->get() as $campaign) {
            $campaign->active = 'yes';
            $campaign->save();
        }
    }

    private function translateCountriesFromISO2($countries)
    {
        $c = collect();
        foreach ($countries as $country)
        {
            $x = Country::where('iso2', $country)->first();
            if(!is_null($x))
                $c->push($x);
        }
        return ($c);
    }

}
