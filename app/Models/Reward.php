<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{


	protected $fillable = ['active','name', 'description', 'points', 'image'];
}

