<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserApi extends Model
{
    protected $fillable = ['user_id', 'key'];

    /**
     * Get the user that owns the api.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
