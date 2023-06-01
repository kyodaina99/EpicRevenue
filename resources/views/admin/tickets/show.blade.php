@extends('admin.shared.layout')

@section('body')
    <h1>Support Ticket Details</h1>

<div>
    <h2>Subject: {{ $ticket->subject }}</h2>
    <p>Status: @if ($ticket->status === 0)
            Pending Support Response
        @elseif ($ticket->status === 1)
            Pending User Response
        @elseif ($ticket->status === 2)
            Closed
        @endif</p>
    <p>Created At: {{ $ticket->created_at }}</p>
    <p>Category: {{ $ticket->category->name }}</p>
</div>

<hr>

<h2>Responses</h2>

@if ($ticket->responses)
    @if ($ticket->responses->count() > 0)
        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach ($ticket->responses as $response)
                    <li class="list-group-item">
                        <p class="response-message">{{ $response->message }}</p>
                        <p class="response-posted-by">Posted By: {{ $response->user->firstname }}</p>
                        <p class="response-posted-at">Posted At: {{ $response->created_at }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p>No responses found.</p>
    @endif
@else
    <p>No responses found.</p>
@endif

<hr>

<h2>Change Status</h2>

<form method="POST" action="{{ route('admin.tickets.updateStatus', $ticket->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
    <label for="status">Status:</label>
    <select name="status" id="status" class="form-control">
        <option value="">Update Status</option>
        <option value="2" {{ $ticket->status === 2 ? 'selected' : '' }}>Closed</option>
        <option value="1" {{ $ticket->status === 1 ? 'selected' : '' }}>Pending user response</option>
    </select>
</div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update Status</button>
    </div>
</form>


<hr>

<h2>Reply to Ticket</h2>

<form method="POST" action="{{ route('admin.tickets.storeResponse', $ticket->id) }}">
    @csrf

    <div class="form-group">
        <label for="response">Response:</label>
        <textarea name="response" id="response" rows="4" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit Response</button>
    </div>
</form>

@endsection
