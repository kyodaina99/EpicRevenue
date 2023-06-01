@extends('shared.layout')

@section('body')
<div class="hero text-center py-6">
    <div class="container">
        <h1 class="hero-heading fw-700">Support Tickets</h1>
        <p class="hero-p">Subject: {{ $ticket->subject }}</p>
    </div>
</div>

<div class="pt-6 pb-4">
    <div class="container">
        <div class="ticket-info">
    <p class="ticket-status">
        Status:
        @if ($ticket->status === 0)
            Pending Support Response
        @elseif ($ticket->status === 1)
            Pending User Response
        @elseif ($ticket->status === 2)
            Closed
        @endif
    </p>
    <p class="ticket-created-at">Created At: {{ $ticket->created_at }}</p>
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
                        <p class="response-created-at">Posted At: {{ $response->created_at }}</p>
                        <p class="response-posted-by">Posted By: {{ $response->user->firstname }}</p>
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

<h2>Reply to Ticket</h2>

<form method="POST" action="{{ route('support.storeResponse', $ticket->id) }}">
    @csrf

    <div class="form-group">
        <label for="response">Response:</label>
        <textarea name="response" id="response" rows="4" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit Response</button>
    </div>
</form>

    </div>
</div>
@endsection
