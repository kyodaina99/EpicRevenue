<?php

namespace App\Http\Controllers;

use App\Models\CampaignRate;
use App\Models\CampaignsCategory;
use App\Models\HomepageFeaturedCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Upload;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
{
    $category_selected = 0;
    $campaigns = Campaign::active();

    if ($request->has('category')) {
        $category_selected = (int) $request->category;
        if ($category_selected !== 0) {
            $campaigns = $campaigns->where('category_id', $category_selected);
        }
    }

    if ($request->has('search')) {
        $searchTerm = $request->search;
        if (!empty($searchTerm)) {
            $campaigns = $campaigns->where('name', 'like', '%' . $searchTerm . '%');
        }
    }

    if ($request->has('country')) {
        $countryId = (int) $request->country;
        if ($countryId !== 0) {
            $campaigns = $campaigns->whereHas('countries', function ($query) use ($countryId) {
                $query->where('country_id', $countryId);
            });
        }
    }

    $campaigns = $campaigns->get();

    // Loop through campaigns and assign featured_img
    foreach ($campaigns as $campaign) {
        $campaign->featured_img = $campaign->featured_img ? Upload::find($campaign->featured_img) : null;
    }

    $categories = CampaignsCategory::whereIn(
        'id',
        Campaign::active()
            ->incentAndMobile(false)
            ->select('category_id')
            ->get()
            ->pluck('category_id')
            ->toArray()
    )->get();

    $category = new CampaignsCategory();
    $category->name = 'All Categories';
    $category->id = 0;
    $categories = $categories->push($category)->sortBy('id');

    $countries = Country::all();
    $country = new Country();
    $country->name = 'All Countries';
    $country->id = 0;
    $countries = $countries->push($country)->sortBy('id')->pluck('name', 'id');

    $data = [
        'campaigns' => $campaigns,
        'countries' => $countries,
        'categories' => $categories,
        'category_selected' => $category_selected,
    ];

    return view('user.campaigns.index')->with($data);
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $campaign = Campaign::where('id', $id)->active()->with('category', 'reports')->firstOrFail();
        $custom_rate = CampaignRate::where(['active' => 'yes', 'campaign_id' => (int) $id, 'user_id' => (int) auth()->user()->id])->first();
        $cap_daily_status = TrackController::checkDailyCap($campaign);

        $featured_img = $campaign->featured_img ? Upload::find($campaign->featured_img) : null;

        return view('user.campaigns.show')->with([
            'campaign' => $campaign,
            'cap_daily_status' => $cap_daily_status,
            'custom_rate' => $custom_rate,
            'featured_img' => $featured_img,
        ]);
    }
}
