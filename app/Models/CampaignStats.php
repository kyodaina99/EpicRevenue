<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignStats extends Model
{
   
    /**
     * Get the campaign that stat own.
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}
