<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\User;
use Auth;
use Cookie;
use App\Models\SupportTicketCategory;


class SupportTicketController extends Controller
{
    
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        $tickets = SupportTicket::where('user_id', $user->id)->latest()->paginate(10);
        return view('user.support.index', compact('tickets'));
    }

    public function create()
    {
        $categories = SupportTicketCategory::all();
        return view('user.support.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            // Add validation rules for other ticket fields if needed
        ]);

        // Create a new support ticket using the SupportTicket model
        $user = User::where('id', auth()->user()->id)->first();
        $ticket = new SupportTicket();
        $ticket->user_id = $user->id;
        $ticket->category_id = $request->input('category');
        $ticket->subject = $request->input('subject');
        $ticket->message = $request->input('message');
        $ticket->save();  

        return redirect()->route('support.show', $ticket->id)->with('success', 'Ticket created successfully.');
    }

    public function storeResponse(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'response' => 'required',
        ]);

        $user = User::where('id', auth()->user()->id)->first();

        $response = $ticket->responses()->create([
            'message' => $request->response,
            'user_id' => $user->id,
        ]);

        $ticket->status = 0;
        $ticket->save();
        
        return redirect()->route('support.show', $ticket->id)->with('success', 'Response added successfully.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('support.show', $ticket->id)->with('success', 'Ticket status updated successfully.');
    }

    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        return view('user.support.show', compact('ticket'));
    }
}
