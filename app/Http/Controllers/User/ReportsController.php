<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now();
        $data['request'] = $request;

        $user = User::where('id', auth()->user()->id)->first();
        $u = $user->id;
        $data['today_clicks'] = Helper::today_clicks();
        $data['today_leads'] = Helper::today_leads();
        $data['earnings_today'] = Helper::earnings_today();
        $data['earnings_month'] = Helper::earnings_monthly();
        $data['earnings_graph'] = collect(Helper::earnings_chart());

        $reports = Report::where('user_id', auth()->user()->id)->with('countries');

        if ($request->has('startMonth') || $request->has('startDay') || $request->has('startYear') || $request->has('endMonth') || $request->has('endDay') || $request->has('endYear') || $request->has('showBy'))
        {
            $start = Carbon::create($request->startYear, $request->startMonth, $request->startDay, 0, 0, 0);
            $end = Carbon::create($request->endYear, $request->endMonth, $request->endDay, 0, 0, 0);
            $reports = $reports->whereBetween('created_at', array($start->toDateTimeString(), $end->toDateTimeString()))->orderBy('id', 'desc');
            if ($request->showBy === 'all')
                $data['reports'] = $reports->paginate(50);
            else
                $data['reports'] = $reports->where('status', (int) $request->showBy)->paginate(50);
        } else {
            $reports = $reports->whereBetween('created_at', array($date->startOfDay()->toDateTimeString(), $date->endOfDay()->toDateTimeString()))->orderBy('id', 'desc');
            $data['reports'] = $reports->paginate(50);
        }

        $data['reports']->load('campaign');

        $data['country_html'] = "";
        if (!$data['reports']->isEmpty())
        {
            $reportsByCountry = $data['reports']->groupBy('country');
            foreach ($reportsByCountry as $key => $value) {
                $arrCountry[] = "['" . $key . "',  " . count($value) . "]";
            }

            if (is_array($arrCountry) && !$arrCountry) {
                $data['country_html'] = implode(",", $arrCountry);
            }
        }

        return view('user.reports.index', $data);
    }


    public function show($id)
    {
        $report = Report::where('id', $id)->where('user_id', (int) auth()->user()->id)->with('campaign')->first();

        if( (int) auth()->user()->id !== (int) $report->user_id)
            return "Permission denied";

        return view('user.reports.show')->with(compact('report'));
    }

}
