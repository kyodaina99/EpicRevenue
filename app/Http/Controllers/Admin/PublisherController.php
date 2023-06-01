<?php

namespace App\Http\Controllers\Admin;

use App\Models\CampaignRate;
use App\Models\Campaign;
use App\Models\Report;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['users'] = User::with('reports', 'balance', 'balance.histories')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.publishers.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function my()
    {
        $data['users'] = User::where('approved_by', auth()->user()->id)
            ->with('reports', 'balance', 'balance.histories')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.publishers.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $data['user'] = User::where('id', $id)->firstOrFail();

        $data['clicks']        = $data['user']->reports()->click()->count();
        $data['leads']         = $data['user']->reports()->lead()->count();
        $data['reversals']     = $data['user']->reports()->reversal()->count();

        $data['today_earnings'] = $data['user']->balance()->first()->histories()->today()->operationOf('add')->sum('amount');
        $data['month_earnings'] = $data['user']->balance()->first()->histories()->month()->operationOf('add')->sum('amount');
        $data['total_earnings']      =  $data['user']->balance()->first()->histories()->operationOf('add')->sum('amount');

        if($request->has('approve'))
        {
            if($request->approve == 1)
            {
                $data['user']->approved = 'yes';
                $data['user']->approved_by = Auth::user()->id;
            }
            elseif($request->approve == 0)
            {
                $data['user']->approved = 'no';
                $data['user']->approved_by = null;
            }
            $data['user']->save();
        }
        return view('admin.publishers.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['user'] = User::where('id', $id)->firstOrFail();
        $data['rates'] = CampaignRate::where('user_id', $id)->with('campaign')->get();

        $data['today_clicks']           = $data['user']->reports()->today()->click()->count();
        $data['today_unique_clicks']    = $data['user']->reports()->today()->click()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
        $data['today_leads']            = $data['user']->reports()->today()->lead()->count();
        $data['today_reversals']        = $data['user']->reports()->today()->reversal()->count();

        $data['today_earnings']         = $data['user']->balance()->first()->histories()->today()->operationOf('add')->where('operation', 'add')->sum('amount');
        $data['month_earnings']         = $data['user']->balance()->first()->histories()->month()->operationOf('add')->sum('amount');
        $data['lastMonth_earnings']     = $data['user']->balance()->first()->histories()->monthLast()->operationOf('add')->sum('amount');
        $data['total_earnings']         = $data['user']->balance()->first()->histories()->operationOf('add')->sum('amount');

        $data['campaign_clicks']        = $data['user']->reports()->click()->count();
        $data['campaign_unique_clicks'] = $data['user']->reports()->click()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
        $data['campaign_leads']         = $data['user']->reports()->lead()->count();
        $data['campaign_reversals']     = $data['user']->reports()->reversal()->count();

        $data['last_reports'] = $data['user']->reports()->with('campaign')->take(5)->orderBy('id', 'desc')->get();

        return view('admin.publishers.edit', $data);
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
        $user = User::where('id', $id)->with('status')->firstOrFail();
        $user->update(array(
            'firstname' => $request->input('firstname'),
            'lastname'  => $request->input('lastname'),
            'email'     => $request->input('email'),
            'phone'     => $request->input('phone'),
            'address1'  => $request->input('address1'),
            'address2'  => $request->input('address2'),
            'city'      => $request->input('city'),
            'state'     => $request->input('state'),
            'zip'       => $request->input('zip')
        ));

        if($request->input('approved') === 'yes')
        {
            $user->approved = 'yes';
            $user->approved_by = Auth::user()->id;
        }
        elseif($request->input('approved') === 'no')
        {
            $user->approved = 'no';
            $user->approved_by = null;
        }

        $user->status->email_confirmed = $request->input('email_confirmed');
        $user->push();

        return redirect('/admin/publishers/' . $user->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

    }
}
