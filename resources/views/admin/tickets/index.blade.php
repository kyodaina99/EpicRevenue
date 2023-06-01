@extends('admin.shared.layout')

@section('body')
    <h1>Support Tickets</h1>

    @if (count($tickets) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}">{{ $ticket->subject }}</a>
                        </td>
                        <td>@if ($ticket->status === 0)
            Pending Support Response
        @elseif ($ticket->status === 1)
            Pending User Response
        @elseif ($ticket->status === 2)
            Closed
        @endif
</td>
                        <td>name</td>
                        <td>{{ $ticket->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tickets->links() }}
    @else
        <p>No support tickets found.</p>
    @endif
@endsection
