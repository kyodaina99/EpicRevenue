<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentDetail extends Model
{
    protected $table = 'user_payment_details';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'q1',
        'q2',
        'q3',
        'q4',
        'threshold',
    ];

    // Define relationships if applicable

    // Define any additional model methods or customizations
}
