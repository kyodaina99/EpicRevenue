@extends('shared.layout')

@section('body')
<div class="hero text-center py-6">
    <div class="container">
        <h1 class="hero-heading fw-700">Support Tickets</h1>
        <p class="hero-p">Need help with something? Write a ticket.</p>
    </div>
</div>

<div class="pt-6 pb-4">
    <div class="container">
        @if (count($tickets) > 0)
    <div class="card">
        <div class="card-body">
            @foreach ($tickets as $ticket)
                <div class="ticket-item mb-4">
                    <div class="ticket-info">
                        <h6 class="ticket-subject">
                            <a href="{{ route('support.show', $ticket->id) }}">{{ $ticket->subject }}</a>
                        </h6>
                        <p class="ticket-status">
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
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="alert alert-info">
        No support tickets found.
    </div>
@endif

    </div>
</div>
@endsection
