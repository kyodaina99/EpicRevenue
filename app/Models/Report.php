<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer'
    ];

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the campaign that report owns.
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    /**
     * Get the user that report owns.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that report owns.
     */
    public function contestUser()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Get the campaign that report owns.
     */
    public function countries()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'code');
    }


    /**
     * Scope a query to only include click reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClick($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include lead reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLead($query)
    {
        return $query->where('status', 2);
    }

    /**
     * Scope a query to only include reversal reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReversal($query)
    {
        return $query->where('status', 3);
    }



    /**
     * Scope a query to only include contest reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContest($query, Carbon $start_at, Carbon $end_at)
    {
        return $query->whereBetween('created_at', [$start_at->toDateTimeString(), $end_at->toDateTimeString()]);
    }

    /**
     * Scope a query to only include today reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        $today = [Carbon::now()->startOfDay()->toDateTimeString(), Carbon::now()->endOfDay()->toDateTimeString()];
        return $query->whereBetween('created_at', $today);
    }

    /**
     * Scope a query to only include today reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYesterday($query)
    {
        $yesterday = [Carbon::yesterday()->toDateTimeString(), Carbon::now()->startOfDay()->subSecond()->toDateTimeString()];
        return $query->whereBetween('created_at', $yesterday);
    }

    /**
     * Scope a query to only include today reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMonth($query)
    {
        $month = [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()];
        return $query->whereBetween('created_at', $month);
    }

    /**
     * Scope a query to only include today reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMonthLast($query)
    {
        $month = [Carbon::now()->subMonth()->startOfMonth()->toDateTimeString(), Carbon::now()->startOfMonth()->subSecond()->toDateTimeString()];
        return $query->whereBetween('created_at', $month);
    }

    /**
     * Scope a query to only include reports of specific time.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDate($query, $date)
    {
        $date = Carbon::parse($date->toDateString());
        $between = [$date->toDateTimeString(), $date->addDay()->subSecond()->toDateTimeString()];
        return $query->whereBetween('created_at', $between);
    }

    /**
     * Scope a query to only include today reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
