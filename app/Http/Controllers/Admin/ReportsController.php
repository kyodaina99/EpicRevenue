<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use App\User;
use App\Http\Helper;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['bodyid'] = 'dark';
        $data['reports'] = Report::with('campaign', 'user')->orderBy('id', 'desc')->paginate(50);
        return view('admin.reports.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data['bodyid'] = 'dark';
        return view('admin.reports.show', $data);
    }

    public function options(Request $request, $id, $status)
    {
        $report = Report::where('id', $id)->firstOrFail();
        if((int) $status === 2)
        {
            $user = User::where('id', $report->user_id)->with('balance', 'balance.histories')->first();

            if( ! Helper::updateCash($user, $report) )
            {
                return "Sorry, Something went wrong!!!";
            }
            $report->status = (int) $status;
        }

        if((int) $status === 1)
        {
            $user = User::where('id', $report->user_id)->with('balance', 'balance.histories')->first();

            if( ! Helper::removeCash($user, $report) )
            {
                return "Sorry, Something went wrong!!!";
            }
            $report->status = (int) $status;
        }

        $report->save();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data['bodyid'] = 'dark';
        $data['report'] = Report::where('id', $id)->with('campaign', 'user')->firstOrFail();
        return view('admin.reports.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
