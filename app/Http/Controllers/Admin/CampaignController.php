<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;
use App\Models\CampaignRate;
use App\Models\CampaignsCategory;
use App\Models\CampaignTarget;
use App\Models\Country;
use App\Models\Postback;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Storage;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getOgadsImport(Request $request)
    {
//        dd($request->all());
        $country = $request->input('country', null);
        $device = $request->input('device', null);

        $network = Postback::where('name', 'ogmobi')->firstOrFail();

        $client = new \GuzzleHttp\Client(['base_uri' => 'https://mobverify.com' ]);
        $response = $client->request('GET', '/api/v1/?affiliateid=10148&ctype=1' . ((!is_null($device)&!empty($device)) ? '&device=' . $device : '') . ((!is_null($country)&!empty($country)) ? '&country=' . $country : ''));

        $offers = json_decode($response->getBody())->offers;
        $o = collect();

        foreach ($offers as $offer)
        {
//            if($network->campaigns()->where('network_campaign_id','%like%', $offer->offerid)->get()->isEmpty())
            $o->push($offer);
        }

        $countries = Country::all();
        //return view('admin.campaigns.ogads', ['offers' => $o, 'countries' => $countries]);
        return view('admin.campaigns.ogads');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function postOgadsImportSelected(Request $request)
    {
        $country = $request->input('country', null);
        $device = $request->input('device', null);

        $selectedOffers = collect($request->input('offers', []));
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://mobverify.com' ]);
        $response = $client->request('GET', '/api/v1/?affiliateid=10148&ctype=1' . ((!is_null($device)&!empty($device)) ? '&device=' . $device : '') . ((!is_null($country)&!empty($country)) ? '&country=' . $country : ''));

        $allOffers = collect(json_decode($response->getBody())->offers);

        $offers = $allOffers->whereIn('offerid', $selectedOffers);
        $this->mergeAndFormatOffers($offers);

        return redirect('/admin/campaigns/');
    }


    private function mergeAndFormatOffers($selectedOffers)
    {
        $category = CampaignsCategory::where('name', 'Mobile Apps')->first();
        $network = Postback::where('name', 'ogmobi')->first();

        $offers = collect();
        foreach ($selectedOffers as $offer) {
            $o = new Campaign();
            $o->user_id = auth()->user()->id;
            $o->category_id = $category->id;
            $o->network_id = $network->id;
            $o->name = substr($offer->name, 0, strpos($offer->name, " -"));
            $o->description = $offer->description;
            $o->requirements = "";
            $o->tracking = "";
            $o->network_campaign_id = $offer->offerid;
            $o->cap = 0;
            $o->cap_daily = 1000;
            $o->mobile = 'yes';
            $o->incent = 'yes';
            $o->active = 'yes';

            $destinationPath = storage_path() . '/app/images/campaign/';
            $fileExt = substr($offer->picture, strrpos($offer->picture, '.') + 1);
            $filename = strval(time()).".".$fileExt;
            $path = ($destinationPath.$filename);
            $offer->picture = preg_replace('/\s+/','%20', $offer->picture);

            file_put_contents(
                $path, file_get_contents( $offer->picture )
            );

            $o->featured_img = $filename;

            $allowedCountries = $this->translateCountriesFromISO2(explode(',', $offer->country));

            $targetsCheck = true;
            $check = $offers->whereIn('name', $o->name)->first();
            $dbTarget = CampaignTarget::where('network_campaign_id', $offer->offerid)->first();
            $dbCampaign = Campaign::where('name', $o->name)->first();
            if (!is_null($dbTarget)) {
                $campaign = $dbTarget->campaign;
                $campaign->network_campaign_id .= "," . $o->network_campaign_id;
                $campaign->save();
                $campaign->countries()->attach($allowedCountries->pluck('id')->toArray());
                $campaign_id = $campaign->id;
                $targetsCheck = false;
            } elseif (!is_null($dbCampaign)) {
                $campaign = $dbCampaign;
                $campaign->network_campaign_id .= "," . $o->network_campaign_id;
                $campaign->save();
                $campaign->countries()->attach($allowedCountries->pluck('id')->toArray());
                $campaign_id = $campaign->id;
            } elseif(!is_null($check)){
                $campaign = $check;
                $campaign->network_campaign_id .= "," . $o->network_campaign_id;
                $campaign->save();
                $campaign->countries()->attach($allowedCountries->pluck('id')->toArray());
                $campaign_id = $campaign->id;
            } else {
                $o->url = $offer->link . "&".$network->ch_slot . "={hash}";
                $o->rate = ($offer->payout / 100) * 70;
                $o->network_rate = $offer->payout;
                $o->network_rate_type = "0";
                $o->save();
                $o->countries()->attach($allowedCountries->pluck('id')->toArray());
                $offers->push($o);
                $campaign_id = $o->id;
            }

            if($targetsCheck)
            {
                $devices = explode(',',$offer->device);

                CampaignTarget::where('network_campaign_id', $offer->offerid)->delete();
                foreach ($allowedCountries as $country)
                {
                    foreach ($devices as $device)
                    {
                        if(!is_null($device))
                        {
                            $cc = new CampaignTarget();
                            $cc->campaign_id      = $campaign_id;

                            if($device == 'iPhone' || $device == 'iPad')
                                $cc->operating_system = 'iOS';
                            elseif ($device == 'Android')
                                $cc->operating_system = 'AndroidOS';

                            $cc->rate             = ($offer->payout / 100) * 70;
                            $cc->network_rate     = $offer->payout;
                            $cc->network_rate_type     = "0";
                            $cc->url              = $offer->link . "&".$network->ch_slot . "={hash}";
                            $cc->country          = $country->name;
                            $cc->network_campaign_id = $offer->offerid;

                            if($device == 'iPhone' || $device == 'Android')
                                $cc->device = "Mobile";
                            elseif ($device == 'iPad')
                                $cc->device = "Tablet";
                            elseif($device == "Desktop")
                                $cc->device = "Desktop";

                            $cc->active    = 'yes';
                            $cc->save();
                        }
                    }
                }
            }
        }
        return $offers;
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($network_id = null)
    {
        $data['campaigns'] = Campaign::orderBy('active')->with('reports');
        if(!is_null($network_id))
            $data['campaigns']->where('network_id', (int) $network_id);
        $data['campaigns'] = $data['campaigns']->paginate(10);
        return view('admin.campaigns.index', $data);
    }


    public function getRates()
    {
        $data['campaigns'] = Campaign::all();
        $data['rates']     = CampaignRate::with('campaign', 'user')->get();
        return view('admin.campaigns.rates', $data);
    }

    public function postRates(Request $request)
    {
        foreach($request->input('campaigns') as $c)
        {
            $rate = CampaignRate::firstOrNew(array(
                'user_id' => (int) $request->input('user_id'),
                'campaign_id' => (int) $c
            ));
            $rate->rate = (float) $request->input('rate');
            $rate->save();
        }

        return redirect('/admin/campaigns/rates');
    }

    public function putRates(Request $request)
    {
        $rate = CampaignRate::findOrFail( (int) $request->input('rate_id') );
        if($request->input('rate_status') === 'yes' || $request->input('rate_status') === 'no')
            $rate->active = $request->input('rate_status');
        else
            $rate->active =  null;
        $rate->rate = (float) $request->input('rate');
        $rate->save();
        return redirect($request->input('return_path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $campaign = new Campaign();
        $campaign_categories = CampaignsCategory::all()->pluck('name', 'id');
        $countries = Country::all()->pluck('name', 'id');
        $networks = Postback::all()->pluck('name', 'id');

        return view('admin.campaigns.create')
            ->with(array(
                'campaign'  => $campaign,
                'campaign_categories' => $campaign_categories,
                'countries' => $countries,
                'networks'  => $networks
            ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if((int) $request->input('cap') !== 0)
            $cap_rule = "|max:".$request->cap;
        else
            $cap_rule = "";

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'description'    => 'string|max:1000',
            'requirements'   => 'string|max:500',
            'creatives_list' => 'string',
            'cap'            => 'integer|max:100000000',
            'cap_daily'      => 'integer'.$cap_rule,
            'category'       => 'exists:campaigns_categories,id',
            'rate'           => 'max:1000000|min:0.1',
            'network_id'     => 'required',
            'network_rate'   => 'max:1000000|min:0.1',
            'countries'      => 'array',
            'feature_image'  => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/campaigns/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create Campaign
        $c = new Campaign();
        $c->user_id          = auth()->user()->id;
        $c->category_id      = $request->category;
        $c->cap              = (int) $request->cap;
        $c->cap_daily        = (int) $request->cap_daily;
        if($request->has('private'))
            $c->private      = 'yes';
        else
            $c->private      = 'no';
        if($request->has('mobile'))
            $c->mobile       = 'yes';
        else
            $c->mobile      = 'no';
        if($request->has('incent'))
            $c->incent       = 'yes';
        else
            $c->incent      = 'no';

        $c->name             = $request->name;
        $c->description      = $request->description;
        $c->requirements     = $request->requirements;
        $c->rate_percentage     = $request->rate_percentage;
        $c->rate             = floatval($request->rate);
        $c->network_rate     = floatval($request->network_rate);
        $c->network_rate_type     = $request->network_rate_type ?? 0;
        $c->tracking         = $request->tracking;
        $c->url              = $request->url;
        $c->network_id       = $request->network_id;
        $c->featured_img     = $request->feature_image;
        $c->creatives        = $request->creatives_list;
        $c->active           = $request->active;
        $c->save();

        // Attach countries to campaign
        $c->countries()->attach($request->countries);

        // Add campaign targets
        for($i=1;$i<count($request->tar_country);$i++){
            $cc = new CampaignTarget();
            $cc->campaign_id      = $c->id;
            $cc->operating_system = $request->tar_os[$i];
            $cc->rate             = $request->tar_rate[$i];
            $cc->network_rate     = $request->tar_network_rate[$i];
            $cc->network_rate_type     = $request->tar_network_rate_type[$i];
            $cc->url              = $request->tar_url[$i];
            $cc->country          = $request->tar_country[$i];

            switch (strtolower($request->tar_device[$i])) {
                case 'tablet':
                    $cc->device   = 'Tablet';
                    break;
                case 'mobile':
                    $cc->device   = 'Mobile';
                    break;
                case 'desktop':
                    $cc->device   = 'Desktop';
                    break;

                default:
                    $cc->device   = 'Desktop';
            }

            if($request->tar_active[$i] === 'yes')
                $cc->active    = 'yes';

            $cc->save();
        }

        return redirect('/admin/campaigns');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $campaign = Campaign::find((int) $id);
        return view('admin.campaigns.show')->with(array('campaign' => $campaign));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);
        $campaign_categories = CampaignsCategory::all()->pluck('name', 'id');
        $countries = Country::all()->pluck('name', 'id');
        $networks = Postback::all()->pluck('name', 'id');
        $campaign_targets = $campaign->targets;

        return view('admin.campaigns.edit')
            ->with(array(
                'campaign'  => $campaign,
                'campaign_categories' => $campaign_categories,
                'countries' => $countries,
                'networks'  => $networks,
                'campaign_targets' => $campaign_targets
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $c = Campaign::find($id);

        if((int) $request->input('cap') !== 0)
            $cap_rule = "|max:".$request->cap;
        else
            $cap_rule = "";

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'description'    => 'string|max:1000',
            'requirements'   => 'string|max:500',
            'cap'            => 'integer|max:100000000',
            'creatives_list' => 'string',
            'cap_daily'      => 'integer'.$cap_rule,
            'category'       => 'exists:campaigns_categories,id',
            'rate'           => 'max:1000000|min:0.1',
            'network_id'     => 'required',
            'network_rate'   => 'max:1000000|min:0.1',
            'network_rate_type'   => 'required',
            'countries'      => 'array',
            'feature_image'  => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/campaigns/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        // Update Campaign
        $c->category_id      = $request->category;
        $c->cap              = (int) $request->cap;
        $c->cap_daily        = (int) $request->cap_daily;

        if($request->has('private'))
            $c->private      = 'yes';
        else
            $c->private      = 'no';
        if($request->has('mobile'))
            $c->mobile       = 'yes';
        else
            $c->mobile      = 'no';
        if($request->has('incent'))
            $c->incent       = 'yes';
        else
            $c->incent      = 'no';
        $c->name             = $request->name;
        $c->description      = $request->description;
        $c->requirements     = $request->requirements;
        $c->rate_percentage  = $request->rate_percentage;
        $c->rate             = floatval($request->rate);
        $c->network_rate     = floatval($request->network_rate);
        $c->network_rate_type     = $request->network_rate_type;
        $c->tracking         = $request->tracking;
        $c->url              = $request->url;
        $c->featured_img     = $request->feature_image;
        $c->creatives        = $request->creatives_list;
        $c->network_id       = $request->network_id;
        $c->active           = $request->active;
        $c->save();

        // Delete all old targets
        $c->targets()->forceDelete();
        // Add campaign targets
        for($i=1;$i<count($request->tar_country);$i++){
            $cc = new CampaignTarget();
            $cc->campaign_id      = $c->id;
            $cc->operating_system = $request->tar_os[$i];
            $cc->network_rate     = $request->tar_network_rate[$i];
            $cc->network_rate_type     = $request->tar_network_rate_type[$i];
            $cc->rate             = $request->tar_rate[$i];
            $cc->url              = $request->tar_url[$i];
            $cc->country          = $request->tar_country[$i];

            switch (strtolower($request->tar_device[$i])) {
                case 'tablet':
                    $cc->device   = 'tablet';
                    break;
                case 'mobile':
                    $cc->device   = 'mobile';
                    break;
                case 'desktop':
                    $cc->device   = 'desktop';
                    break;

                default:
                    $cc->device   = 'desktop';
            }

            if($request->tar_active[$i] === 'yes')
                $cc->active    = 'yes';

            $cc->save();
        }

        // Attach countries to campaign
        $c->countries()->sync($request->countries);

        return redirect('/admin/campaigns/' . $c->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Show Feature image
     *
     * @param string $name
     * @return Response
     * */
    public function featureImage($id)
    {
        $c = Campaign::findOrFail($id);
        $path = storage_path('app/images/campaign/' . $c->featured_img);
        $path1 = storage_path('app/public/images/campaign/' . $c->featured_img);
        if( \File::exists($path) ) {
            $filetype = \File::type($path);
            $response = \Response::make(\File::get($path), 200);
            $response->header('Content-Type', $filetype);
            return $response;
        } else if( \File::exists($path1) ) {
            $filetype = \File::type($path1);
            $response = \Response::make(\File::get($path1), 200);
            $response->header('Content-Type', $filetype);
            return $response;
        } else {
            $path = storage_path('app/images/campaign/default.jpg');
            $filetype = \File::type($path);
            $response = \Response::make(\File::get($path), 200);
            $response->header('Content-Type', $filetype);
            return $response;
        }
    }

    public function categories()
    {
        $categories = CampaignsCategory::all();
        return $categories;
    }
}
