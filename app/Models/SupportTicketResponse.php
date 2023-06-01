<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SupportTicketResponse extends Model
{
    protected $table = 'support_tickets_responses';

    protected $fillable = [
        'ticket_id',
        'message',
        'user_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
