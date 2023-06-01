<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Campaign;
use App\Models\CampaignRate;
use App\Models\CampaignsCategory;
use App\Models\CampaignTarget;
use App\Models\Country;
use App\Models\Postback;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $query = Campaign::with('network');

        if(!empty($request->input('search', '')) && $request->input('search_by', 'id') !== 'created_at')
        {
            $query = $query->where($request->input('search_by', 'id'), 'like', '%' . $request->input('search') . '%');
        }

        $query = $query->orderBy($request->input('order_by', 'active'), $request->input('order', 'desc'));

        $campaigns = $query->paginate(10);

        foreach($campaigns as $c):
            $c->clicks = $c->reports()->count();
//            $c->unique_clicks = $c->reports()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
            $c->leads = $c->reports()->lead()->count();
            $c->reversals = $c->reports()->reversal()->count();
        endforeach;

        return $campaigns;
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
            $request->active = $request->input('rate_status');
        else
            $request->active =  null;
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
        $campaign_categories = CampaignsCategory::all()->lists('name', 'id');
        $countries = Country::all()->lists('name', 'id');
        $networks = Postback::all()->lists('name', 'id');

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
            'name'                => 'required|string|max:255',
            'description'         => 'required|string|max:500',
            'requirements'        => 'required|string|max:500',
            'cap'                 => 'required|integer|max:100000000',
            'cap_daily'           => 'required|integer'.$cap_rule,
            'category'            => 'required|exists:campaigns_categories,id',
            'rate'                => 'required|max:1000000|min:0.1',
            'network_id'          => 'required',
            'network_rate'        => 'required|max:1000000|min:0.1',
            //'network_rate_type'   => 'required',
            'countries'           => 'required|array',
            'feature_image'       => 'mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/campaigns/create')
                ->withErrors($validator)
                ->withInput();
        }


        // Store Image
        $file = $request->file('feature_image');
        $destinationPath = storage_path() . '/app/images/campaign/';
        $fileExt = $file->getClientOriginalExtension();
        $filename = strval(time()).".".$fileExt;
        $file->move($destinationPath, $filename);
        $featured_img = $filename;

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
        $c->name                = $request->name;
        $c->description         = $request->description;
        $c->requirements        = $request->requirements;
        $c->rate                = floatval($request->rate);
        $c->network_rate        = floatval($request->network_rate);
        $c->network_rate_type   = $request->network_rate_type;
        $c->tracking            = $request->tracking;
        $c->url                 = $request->url;
        $c->network_id          = $request->network_id;
        $c->featured_img        = $featured_img;
        $c->active              = $request->active;
        $c->save();

        // Attach countries to campaign
        $c->countries()->attach($request->countries);

        // Add campaign targets
        for($i=1;$i<count($request->tar_country);$i++){
            $cc = new CampaignTarget();
            $cc->campaign_id           = $c->id;
            $cc->operating_system      = $request->tar_os[$i];
            $cc->rate                  = $request->tar_rate[$i];
            $cc->network_rate          = $request->tar_network_rate[$i];
            $cc->network_rate_type     = $request->tar_network_rate_type[$i];
            $cc->url                   = $request->tar_url[$i];
            $cc->country               = $request->tar_country[$i];

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
        $campaign_categories = CampaignsCategory::all()->lists('name', 'id');
        $countries = Country::all()->lists('name', 'id');
        $networks = Postback::all()->lists('name', 'id');
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
            'name'                => 'required|string|max:255',
            'description'         => 'required|string|max:500',
            'requirements'        => 'required|string|max:500',
            'cap'                 => 'required|integer|max:100000000',
            'cap_daily'           => 'required|integer'.$cap_rule,
            'category'            => 'required|exists:campaigns_categories,id',
            'rate'                => 'required|max:1000000|min:0.1',
            'network_id'          => 'required',
            'network_rate'        => 'required|max:1000000|min:0.1',
            //'network_rate_type'   => 'required',
            'countries'           => 'required|array',
            'feature_image'       => 'mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/campaigns/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('feature_image');

        // Delete old image
        if(! is_null($file)) {
            if( Storage::exists('app/images/campaign/' . $c->featured_img) )
                Storage::delete('app/images/campaign/' . $c->featured_img);

            // Store Image
            $destinationPath = storage_path() . '/app/images/campaign/';
            $fileExt = $file->getClientOriginalExtension();
            $filename = strval(time()) . "." . $fileExt;
            $file->move($destinationPath, $filename);
            $c->featured_img = $filename;
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
        $c->name                = $request->name;
        $c->description         = $request->description;
        $c->requirements        = $request->requirements;
        $c->rate                = floatval($request->rate);
        $c->network_rate        = floatval($request->network_rate);
        $c->network_rate_type   = $request->network_rate_type;
        $c->tracking            = $request->tracking;
        $c->url                 = $request->url;
        $c->network_id          = $request->network_id;
        $c->active              = $request->active;
        $c->save();

        // Delete all old targets
        $c->targets()->forceDelete();
        // Add campaign targets
        for($i=1;$i<count($request->tar_country);$i++){
            $cc = new CampaignTarget();
            $cc->campaign_id           = $c->id;
            $cc->operating_system      = $request->tar_os[$i];
            $cc->network_rate_type     = $request->tar_network_rate_type[$i];
            $cc->network_rate          = $request->tar_network_rate[$i];
            $cc->rate                  = $request->tar_rate[$i];
            $cc->url                   = $request->tar_url[$i];
            $cc->country               = $request->tar_country[$i];

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
        if( \File::exists($path) ) {
            $filetype = \File::type($path);
            $response = \Response::make(\File::get($path), 200);
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

}
