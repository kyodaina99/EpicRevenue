@extends('shared.layout')
@section('body')
    <div class="container">
        <div class="page-header">
            <h1>Live Contests</h1>
        </div>
        <div class="row">
            @if(count($live_contests) > 0)
                <?php $i = 0 ?>
                @foreach($live_contests as $c)
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3><a href="{!! url('/contests/' . $c->id) !!}">{!! $c->name !!}</a></h3>
                                <p>{!! $c->description !!}</p>
                                <p><strong>Start at:</strong> {!! $c->start_at->format('l jS \\of F Y') !!}</p>
                                <p><strong>End at:</strong> {!! $c->end_at->format('l jS \\of F Y') !!}</p>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @if($i % 3 == 0)
                        <div class="clearfix"></div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-danger" role="alert">There are no Live Contests at this time.</div>
            @endif
            <div class="clearfix"></div>
        </div>

        <div class="page-header">
            <h1>Upcoming Contests</h1>
        </div>
        <div class="row">
            @if(count($up_contests) > 0)
                <?php $i = 0 ?>
                @foreach($up_contests as $c)
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h3><a href="{!! url('/contests/' . $c->id) !!}">{!! $c->name !!}</a></h3>
                                <p>{!! $c->description !!}</p>
                                <p><strong>Start at:</strong> {!! $c->start_at->format('l jS \\of F Y') !!}</p>
                                <p><strong>End at:</strong> {!! $c->end_at->format('l jS \\of F Y') !!}</p>
                            </div>
                        </div>
                    </div>
                    <?php $i++ ?>
                    @if($i % 3 == 0)
                        <div class="clearfix"></div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-danger" role="alert">There are no Upcoming Contests at this time.</div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@endsection