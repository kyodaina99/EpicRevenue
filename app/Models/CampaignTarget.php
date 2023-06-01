<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignTarget extends Model
{
    /**
     * Get the target that campaign owns.
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    /**
     * Scope a query to only include active campaign target.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 'yes');
    }

    /**
     * Scope a query to only include active campaign target.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCountry($query, $country)
    {
        return $query->where('country', 'like', '%'.$country.'%');
    }
}
