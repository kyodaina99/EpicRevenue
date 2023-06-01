<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SupportTicketResponse;
use App\User;

class SupportTicket extends Model
{
    protected $fillable = ['category_id', 'subject', 'message', 'status'];

    public function category()
    {
        return $this->belongsTo(SupportTicketCategory::class, 'category_id');
    }
    public function responses()
    {
        return $this->hasMany(SupportTicketResponse::class, 'ticket_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class SupportTicketCategory extends Model
{
    protected $fillable = ['name'];

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'category_id');
    }
}
