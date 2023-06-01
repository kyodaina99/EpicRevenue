<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    /**
     * The category that belong to the campaign.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\CampaignsCategory', 'category_id');
    }

    /**
     * The network that belong to the campaign.
     */
    public function network()
    {
        return $this->belongsTo('App\Models\Postback', 'network_id');
    }


    /**
     * Get the stats for the campaign.
     */
    public function stats()
    {
        return $this->hasMany('App\Models\CampaignStats', 'campaign_id');
    }

    /**
     * The upload file that belong to the campaign.
     */
    public function featured_img()
    {
        return $this->belongsTo('App\Models\Upload', 'featured_img');
    }

    /**
     * The countries that belong to the campaign.
     */
    /*public function countries()
    {
        return $this->belongsToMany('App\Models\Country', 'campaign_countries', 'campaign_id', 'country_id')->withTimestamps();
    }*/

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'campaign_countries');
    }

    /**
     * Get the campaign target record associated with the campaign.
     */
    public function targets()
    {
        return $this->hasMany('App\Models\CampaignTarget');
    }

    /**
     * Get the campaign target record associated with the campaign.
     */
    public function activeTargets()
    {
        return $this->hasMany('App\Models\CampaignTarget')->where('active', 'yes');
    }


    /**
     * Get the campaign target record associated with the campaign.
     */
    public function rates()
    {
        return $this->hasMany('App\Models\CampaignRate');
    }

    /**
     * Get the campaign reports record associated with the campaign.
     */
    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }


    /**
     * Scope a query to only include active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 'yes');
    }


    /**
     * Scope a query to only include active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMobile($query)
    {
        return $query->where('mobile', 'yes');
    }


    /**
     * Scope a query to only include active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncent($query)
    {
        return $query->where('incent', 'yes');
    }


    /**
     * Scope a query to only include active campaigns.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncentAndMobile($query, $condition = true)
    {
        if($condition) {
            $where = [['incent' , '=', 'yes'], ['mobile' , '=', 'yes']];
        } else {
            $where = [['incent' , '!=', 'yes'], ['mobile' , '!=', 'yes']];
        }
        return $query->where($where);
    }
}

