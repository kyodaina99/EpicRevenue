<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignsCategory extends Model
{
    /**
     * The campaign categories that belong to the Campaign.
     */
    public function campaigns()
    {
        return $this->hasMany('App\Models\Campaign', 'category_id');
    }
}
