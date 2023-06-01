<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountStatus extends Model
{
    protected $table = 'account_statuses';

    protected $fillable = ['user_id', 'email_confirm_send_at'];

    protected $dates = ['email_confirm_send_at'];

    /**
     * Get the user that owns this status.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
