<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Report;
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
        $today = Carbon::now();
        $data['up_contests'] = Contest::where('start_at', '>', $today->toDateTimeString())
            ->where('end_at', '>', $today->toDateTimeString())
            ->orderBy('start_at', 'desc')
            ->get();
        $data['live_contests'] = Contest::where('start_at', '<', $today->toDateTimeString())
            ->where('end_at', '>', $today->toDateTimeString())
            ->orderBy('start_at', 'desc')
            ->get();
        return view('user.contests.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $today = Carbon::now();
        $data['contest'] = Contest::where('id', $id)->with('rewards')->firstOrFail();

        if($data['contest']->type === 'referral')
        {
            $users = User::approved()
                ->where('referral_id', '!=', 0)
                ->contest($data['contest']->start_at, $data['contest']->end_at)
                ->leftJoin('user_balances', 'user_balances.user_id', '=', 'users.id')
                ->leftJoin('user_balance_histories', 'user_balance_histories.user_balance_id', '=', 'user_balances.id')
                ->where('user_balance_histories.operation', 'add')
                ->select(
                    'users.id as user_id',
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

        foreach ($data['reports'] as $position => $r) {
            $r->position = $position + 1;
        }

        $data['user_rank'] = $data['reports']->where('user_id', (string) auth()->user()->id)->first();

        return view('user.contests.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
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
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
