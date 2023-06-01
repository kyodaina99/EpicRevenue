<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{

    protected $fillable = ['user_id'];

    /**
     * Get the user that owns the balance.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     *
     */
    public function contestUser()
    {
        return $this->hasMany('App\Models\UserBalanceHistory', 'user_balance_id', 'id')
            ->whereRaw('ROUND(SUM(user_balance_histories.amount)) > 0.2');
    }

    /**
     * Get the balance histories for the user balance.
     */
    public function histories()
    {
        return $this->hasMany('App\Models\UserBalanceHistory', 'user_balance_id', 'id');
    }
}
