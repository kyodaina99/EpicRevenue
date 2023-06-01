<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Helper;
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
    public function index(Request $request)
    {
        $query = User::with('status');

        if($request->input('my') == 'true' && app()->environment('staging', 'production'))
            $query = $query->where('approved_by', auth()->user()->id);

        if($request->input('status') == 'true')
            $query = $query->where('approved', 'no');

        if(!empty($request->input('search', '')) && $request->input('search_by', 'id') !== 'created_at')
        {
            $query = $query->where($request->input('search_by', 'id'), 'like', '%' . $request->input('search') . '%');
        }



        $query = $query->orderBy($request->input('order_by', 'id'), $request->input('order', 'desc'));

        $publishers = $query->paginate(10);

        foreach ($publishers as $publisher) {
            $publisher->total_earned = $publisher->where('id', $publisher->id)->first()->reports()->lead()->sum('rate');
            //$publisher->total_paid = $publisher->balance()->first()->histories()->where('operation', 'withdraw')->sum('amount');
        }

        return $publishers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function my()
    {
        $users = User::where('approved_by', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $users;
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
        $data['user'] = User::where('id', $id)->with('socialAccounts')->firstOrFail();

        $data['clicks']        = $data['user']->reports()->click()->count();
        $data['leads']         = $data['user']->reports()->lead()->count();
        $data['reversals']     = $data['user']->reports()->reversal()->count();

        $data['today_earnings'] = $data['user']->balance()->first()->histories()->today()->operationOf('add')->sum('amount');
        $data['month_earnings'] = $data['user']->balance()->first()->histories()->month()->operationOf('add')->sum('amount');
        $data['total_earnings']      =  $data['user']->balance()->first()->histories()->operationOf('add')->sum('amount');

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['user'] = User::where('id', $id)->with('status')->firstOrFail();
        $data['user']->role = $data['user']->role . "";
        $data['rates'] = CampaignRate::where('user_id', $id)->with('campaign')->get();

        $data['today_clicks']           = $data['user']->reports()->today()->click()->count();
        $data['today_unique_clicks']    = $data['user']->reports()->today()->click()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
        $data['today_leads']            = $data['user']->reports()->today()->lead()->count();
        $data['today_reversals']        = $data['user']->reports()->today()->reversal()->count();

        $data['today_earnings']         = $data['user']->balance()->first()->histories()->today()->operationOf('add')->sum('amount');
        $data['month_earnings']         = $data['user']->balance()->first()->histories()->month()->operationOf('add')->sum('amount');
        $data['lastMonth_earnings']     = $data['user']->balance()->first()->histories()->monthLast()->operationOf('add')->sum('amount');
        $data['total_earnings']         = $data['user']->balance()->first()->histories()->operationOf('add')->sum('amount');

        $data['campaign_clicks']        = $data['user']->reports()->click()->count();
//        $data['campaign_unique_clicks'] = $data['user']->reports()->click()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
        $data['campaign_leads']         = $data['user']->reports()->lead()->count();
        $data['campaign_reversals']     = $data['user']->reports()->reversal()->count();

        $data['last_reports'] = $data['user']->reports()->orderBy('id', 'desc')->take(5)->get();

        return $data;
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
            'firstname' => Helper::requestInput($request, 'user', 'firstname'),
            'lastname'  => Helper::requestInput($request, 'user', 'lastname'),
            'role'  => Helper::requestInput($request, 'user', 'role'),
            'email'     => Helper::requestInput($request, 'user', 'email'),
            'phone'     => Helper::requestInput($request, 'user', 'phone'),
            'address1'  => Helper::requestInput($request, 'user', 'address1'),
            'address2'  => Helper::requestInput($request, 'user', 'address2'),
            'city'      => Helper::requestInput($request, 'user', 'city'),
            'state'     => Helper::requestInput($request, 'user', 'state'),
            'zip'       => Helper::requestInput($request, 'user', 'zip')
        ));

        if($request->input('user')['approved'] === 'yes')
        {
            $user->approved = 'yes';
            $user->approved_by = auth()->user()->id;
        }
        elseif($request->input('user')['approved'] === 'no')
        {
            $user->approved = 'no';
            $user->approved_by = null;
        }

        $user->status->email_confirmed = $request->input('user')['status']['email_confirmed'];
        $user->push();

        return 'success';
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


    public function approval(Request $request, $id)
    {
        $user = User::find($id);
        if($request->has('approve'))
        {
            if($request->approve === 'yes')
            {
                $user->approved = 'yes';
                $user->approved_by = Auth::user()->id;
            }
            elseif($request->approve === 'no')
            {
                $user->approved = 'no';
                $user->approved_by = null;
            }
            $user->save();
            return 'success';
        }
        return 'fail';
    }
}
