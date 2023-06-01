@extends('shared.layout')
@section('body')
    <div class="container">
        <div class="page-header">
            <h1>{!! $contest->name !!}</h1>
        </div>
        <h3><small><span class="glyphicon glyphicon-time"></span> Start at: {!! $contest->start_at->format('l jS \\of F Y') !!}</small><br><small><span class="glyphicon glyphicon-time"></span> End at: {!! $contest->end_at->format('l jS \\of F Y') !!}</small></h3>
        @if($contest->end_at->isPast())
            <div class="alert alert-danger" role="alert">This Contest ended on {!! $contest->end_at->format('l jS \\of F Y') !!}</div>
        @endif
        <p>
            {!! $contest->description !!}
        </p>

        <div class="panel panel-default">
            <div class="panel-heading">Rewards</div>
            <table class="table table-bordered table-hover">
                <tr>
                    <th width="100">Position #</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
                @foreach($contest->rewards as $r)
                    <tr>
                        <td class="text-center">{!! $r->position !!}</td>
                        <td>{!! $r->name !!}</td>
                        <td>{!! $r->description !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        @unless($contest->start_at->isFuture())
            @if(is_null($user_rank))
                @if($contest->type === 'referral')
                    <div class="alert alert-warning" role="alert">You haven't enough referrals to be ranked in this contest.</div>
                @elseif($contest->type === 'top_earner')
                    <div class="alert alert-warning" role="alert">Your earnings are not sufficient to be ranked in this contest.</div>
                @endif
            @else
                <div class="alert alert-info" role="alert">Your rank is {!! $user_rank->position !!}.</div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">Rankings</div>
                @if(count($reports) > 0)
                    <table class="table table-bordered table-hover">
                        @if($contest->type === 'referral')
                            <tr>
                                <th width="100">Position #</th>
                                <th>Name</th>
                                <th>Referred Users</th>
                            </tr>
                            @foreach($reports as $r)
                                <tr @if($user_rank == $r) class="success" @endif>
                                    <td class="text-center">{!! $r->position !!}</td>
                                    <td>{!! $r->firstname !!} {!! $r->lastname !!}</td>
                                    <td>{!! $r->count !!}</td>
                                </tr>
                            @endforeach
                        @elseif($contest->type === 'top_earner')
                            <tr>
                                <th width="100">Position #</th>
                                <th>Name</th>
                                <th>Earned</th>
                            </tr>
                            @foreach($reports as $r)
                                <tr @if($user_rank == $r) class="info" @endif>
                                    <td class="text-center">{!! $r->position !!}</td>
                                    <td>{!! $r->user->firstname !!} {!! $r->user->lastname !!}</td>
                                    <td>{!! $r->earning !!}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                @else
                    <div class="alert alert-info" role="alert">Ranking for this contest cannot be shown at this time.</div>
                @endif
            </div>
        @endunless
    </div>
@endsection