<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['today_clicks'] = Report::today()->count();
        $data['today_leads'] = Report::lead()->today()->count();
        $data['earnings_today'] = Report::lead()->today()->sum('network_rate');
        $data['profits_today'] = Report::lead()->today()->sum('rate');
        $data['profits_today'] = $data['earnings_today'] - $data['profits_today'];

        $data['yesterday_clicks'] = Report::yesterday()->count();
        $data['yesterday_leads'] = Report::lead()->yesterday()->count();
        $data['earnings_yesterday'] = Report::lead()->yesterday()->sum('network_rate');
        $data['profits_yesterday'] = Report::lead()->yesterday()->sum('rate');
        $data['profits_yesterday'] = $data['earnings_yesterday'] - $data['profits_yesterday'];

        $data['month_clicks'] = Report::month()->count();
        $data['month_leads'] = Report::lead()->month()->count();
        $data['earnings_month'] = Report::lead()->month()->sum('network_rate');
        $data['profits_month'] = Report::lead()->month()->sum('rate');
        $data['profits_month'] = $data['earnings_month'] - $data['profits_month'];

        $data['total_clicks'] = Report::count();
        $data['total_leads'] = Report::lead()->count();
        $data['earnings_total'] = Report::lead()->sum('network_rate');
        // Total profits
        $data['profits_total'] = Report::lead()->sum('rate');
        $data['profits_total'] = $data['earnings_total'] - $data['profits_total'];

        return $data;
    }
}
