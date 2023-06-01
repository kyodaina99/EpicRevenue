<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'type', 'start_at', 'end_at'];


    /**
     * Get the rewards for the contest.
     */
    public function rewards()
    {
        return $this->hasMany('App\Models\ContestRewards');
    }

}
