<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserBalanceHistory extends Model
{
    protected $fillable = ['user_balance_id', 'referrer_id', 'type', 'operation', 'amount', 'pay_to', 'method'];


    /**
     * Get the user balance that owns the history.
     */
    public function balance()
    {
        return $this->belongsTo('App\Models\UserBalance', 'user_balance_id', 'id');
    }


    public function scopeTypeOf($query, $type)
    {
        return $query->where('type',  $type);
    }

    public function scopeOperationOf($query, $operation)
    {
        return $query->where('operation',  $operation);
    }


    public function scopeCleared($query)
    {
        $query->where('created_at', '<=', Carbon::now()->subDays(7)->toDateTimeString());
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

}
