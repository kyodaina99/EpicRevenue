<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'username', 'email', 'password', 'phone', 'address1', 'address2', 'city', 'state', 'zip', 'role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];



    /**
     * Get the statuses record associated with the user.
     */
    public function mailchimp()
    {
        return $this->hasMany('App\Models\Mailchimp', 'user_id', 'id');
    }

    /**
     * Get the user who own this record.
     */
    public function paymentDetail()
    {
        return $this->hasOne('App\Models\UserPaymentDetail');
    }

    /**
     * Get the statuses record associated with the user.
     */
    public function status()
    {
        return $this->hasOne('App\Models\AccountStatus');
    }


    public function reports(){
        return $this->hasMany('App\Models\Report');
    }

    /**
     * Get the email record associated with the user.
     */
    public function emailNotification()
    {
        return $this->hasOne('App\Models\EmailNotification');
    }

    /**
     * Get the balance record associated with the user.
     */
    public function balance()
    {
        return $this->hasOne('App\Models\UserBalance');
    }

    /**
     * Get the api record associated with the user.
     */
    public function api()
    {
        return $this->hasOne('App\Models\UserApi');
    }

    /**
     * Get the rates for the user.
     */
    public function rates()
    {
        return $this->hasMany('App\Models\CampaignRate');
    }

    /**
     * Scope a query to only include contest reports.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContest($query, Carbon $start_at, Carbon $end_at)
    {
        return $query->whereBetween('users.created_at', [$start_at->toDateTimeString(), $end_at->toDateTimeString()]);
    }


    /**
     * Scope a query to only include active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', 'yes');
    }
}
