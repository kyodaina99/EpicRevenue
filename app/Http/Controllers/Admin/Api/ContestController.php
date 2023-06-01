<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Contest;
use App\Models\ContestRewards;
use App\Models\Report;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contest::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_at = Carbon::parse($request->input('contest')['start_at'])->startOfDay()->addDay();
        $end_at = Carbon::parse($request->input('contest')['end_at'])->endOfDay();

        if(isset($request->input('contest')['description']))
            $d = $request->input('contest')['description'];
        else
            $d = null;

        $data['contest'] = Contest::create([
            'name'        => $request->input('contest')['name'],
            'description' => $d,
            'start_at'    => $start_at->toDateTimeString(),
            'end_at'      => $end_at->toDateTimeString(),
            'type'        => $request->input('contest')['type']
        ]);
        $rewards = $request->input('rewards');

        for ($i=0; $i <= count($rewards) - 1; $i++) {
            $data['rewards'][$i] = ContestRewards::create([
                'contest_id' => (int) $data['contest']->id,
                'position'   => (int) $rewards[$i]['position'],
                'name'     => $rewards[$i]['name'],
                'description' => $rewards[$i]['description']
            ]);
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['contest'] = Contest::where('id', (int) $id)->with('rewards')->firstOrFail();
        if($data['contest']->type === 'referral')
        {
            $users = User::approved()
                ->where('referral_id', '!=', 0)
                ->contest($data['contest']->start_at, $data['contest']->end_at)
                ->leftJoin('user_balances', 'user_balances.user_id', '=', 'users.id')
                ->leftJoin('user_balance_histories', 'user_balance_histories.user_balance_id', '=', 'user_balances.id')
                ->where('user_balance_histories.operation', 'add')
                ->select(
                    'users.id',
                    'users.referral_id',
                    \DB::raw('ROUND(SUM(user_balance_histories.amount), 2) as earned')
                )
                ->havingRaw('earned > 5')
                ->groupBy('users.id')
                ->get();
            $eligibles = $users->lists('referral_id');
            $eligible_users = User::approved()->whereIn('id', $eligibles)->select('users.id', 'users.firstname', 'users.lastname')->get();

            foreach ($eligible_users as $eu) {
                $eu->count = $users->where('referral_id', $eu->id)->count();
                $eu->users = $users->where('referral_id', $eu->id)->lists('id');
            }

            $data['reports'] = $eligible_users->sortBy('count')->reverse();
        } else {
            $data['reports'] = Report::lead()
                ->contest($data['contest']->start_at, $data['contest']->end_at)
                ->select('user_id', \DB::raw("COUNT('status') as leads"), \DB::raw("ROUND(SUM(rate), 2) as earning"))
                ->orderBy('earning', 'desc')
                ->havingRaw('earning > 0')
                ->groupBy('user_id')
                ->with('user')
                ->get();
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contest = Contest::where('id', (int) $id)->with('rewards')->firstOrFail();
        return $contest;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['contest'] = Contest::where('id', (int) $id)->firstOrFail();
        $data['contest']->rewards()->delete();

        $start_at = Carbon::parse($request->input('contest')['start_at'])->startOfDay()->addDay();
        $end_at = Carbon::parse($request->input('contest')['end_at'])->endOfDay();

        if(isset($request->input('contest')['description']))
            $d = $request->input('contest')['description'];
        else
            $d = null;

        $data['contest']->update([
            'name'        => $request->input('contest')['name'],
            'description' => $d,
            'start_at'    => $start_at->toDateTimeString(),
            'end_at'      => $end_at->toDateTimeString(),
            'type'        => $request->input('contest')['type']
        ]);
        $rewards = $request->input('rewards');

        for ($i=0; $i <= count($rewards) - 1; $i++) {
            $data['rewards'][$i] = ContestRewards::create([
                'contest_id'  => (int) $data['contest']->id,
                'position'    => (int) $rewards[$i]['position'],
                'name'        => $rewards[$i]['name'],
                'description' => $rewards[$i]['description']
            ]);
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Contest::where('id', (int) $id)->delete();
    }
}
