<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserPaymentMethod extends Model
{
    protected $fillable = ['name', 'question_1', 'question_2', 'question_3', 'question_4'];
}
/*
class UserPaymentMethod extends Model
{
    protected $table = 'user_payment_methods';

    // Define the relationships here
    // For example, if there is a relationship with UserPaymentDetail model:
    public function paymentDetails()
    {
        return $this->hasMany(UserPaymentDetail::class);
    }
}
*/
