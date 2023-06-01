<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Report;
use Illuminate\Http\Request;
use App\User;
use App\Http\Helper;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search_by = $request->input('search_by', 'reports.id');
        $search    = $request->input('search', '');
        $order_by  = $request->input('search_by', 'reports.id');
        $order     = $request->input('order', 'desc');

        $query = Report::with('campaign');

        if(!empty($search) && $search_by !== 'reports.created_at')
        {
            $query = $query->where($search_by, 'like', '%' . $search . '%');
        }

        $query = $query->orderBy($order_by, $order);

        $reports = $query->paginate(50);

        foreach ($reports as $report) {
            $agent = new \Jenssegers\Agent\Agent();
            $agent->setUserAgent($report->user_agent);

            $report->os = $agent->platform();
        }

        return $reports;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $report = Report::where('id', $id)->with('campaign', 'user')->firstOrFail();

        $agent = new Agent();
        $agent->setUserAgent($report->user_agent);

        $report->browser = $agent->browser();
        $report->os = $agent->platform();
        return $report;
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
        $report = Report::where('id', $id)->firstOrFail();
        if((int) $request->input('status') === 2)
        {
            $user = User::where('id', $report->user_id)->with('balance', 'balance.histories')->first();

            if( ! Helper::updateCash($user, $report) )
            {
                return "Sorry, Something went wrong!!!";
            }
            $report->status = (int) $request->input('status');

        }

        if((int) $request->input('status') === 1)
        {
            $user = User::where('id', $report->user_id)->with('balance', 'balance.histories')->first();

            if( ! Helper::removeCash($user, $report) )
            {
                return "Sorry, Something went wrong!!!";
            }
            $report->status = (int) $request->input('status');
        }

        $report->save();
        return $report->status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Report::destroy((int) $id);
        return 'success';
    }

}
