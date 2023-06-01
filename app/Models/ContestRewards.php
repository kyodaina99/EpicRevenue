<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestRewards extends Model
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'contest_id' => 'integer',
        'position'   => 'integer',
        'reward'     => 'float',
        'points'     => 'integer'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contest_id' ,'position', 'name', 'description'];


    /**
     * Get the post that owns the comment.
     */
    public function contest()
    {
        return $this->belongsTo('App\Models\Contest');
    }
}
