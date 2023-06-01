<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    protected $fillable = ['user_id'];
    /**
     * Get the user that owns the resource.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
