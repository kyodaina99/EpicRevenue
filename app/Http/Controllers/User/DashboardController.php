<?php

namespace App\Http\Controllers\User;

use App\Http\Helper;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Report;
use App\Models\UserBalanceHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /*
     * Display dashboard
     *
     * @return Response
     */
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $data['today_clicks'] = Helper::today_clicks();
        $data['today_leads'] = Helper::today_leads();
        $data['earnings_today'] = Helper::earnings_today();
        $data['earnings_month'] = Helper::earnings_monthly();
        $data['earnings_graph'] = collect(Helper::earnings_chart());
        $data['top_campaigns'] = Helper::top_campaigns(Carbon::now());

        return view('user.dashboard', $data);
    }

}
