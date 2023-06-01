<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postback extends Model
{
    protected $fillable = ['ch_slot', 'veri_slot', 'name'];

    /**
     * Get the comments for the blog post.
     */
    public function campaigns()
    {
        return $this->hasMany('App\Models\Campaign', 'network_id');
    }
}
