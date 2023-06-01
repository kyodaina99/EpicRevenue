<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * The users that belong to the role.
     */
    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_countries', 'campaign_id', 'country_id');
    }
}
