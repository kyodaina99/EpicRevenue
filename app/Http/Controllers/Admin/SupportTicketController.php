<?php

namespace App\Http\Controllers\Admin;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('admin.tickets.show', $ticket->id)->with('success', 'Ticket status updated successfully.');
    }


    public function storeResponse(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'response' => 'required',
        ]);

        $response = $ticket->responses()->create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
            'message' => $request->response,
        ]);

        $ticket->status = 1;
        $ticket->save();

        return redirect()->route('admin.tickets.show', $ticket->id)->with('success', 'Response added successfully.');
    }

}
