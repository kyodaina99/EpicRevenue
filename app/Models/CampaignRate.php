<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'campaign_id', 'rate', 'reason'];

    /**
     * Get the target that campaign owns.
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    /**
     * Get the user that owns the rate.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
