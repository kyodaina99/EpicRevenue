@extends('admin.shared.layout')
@section('body')
    @if(Session::has('success'))
        <div class="alert alert-success">
            {!! Session::get('success') !!}
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger">
            {!! Session::get('error') !!}
        </div>
    @else

    @endif
    <h3>Rewards lists</h3>
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>Id</th>
            <th>Status</th>
            <th>Name</th>
            <th>Description</th>
            <th>Points</th>
            <th colspan="2">Options</th>
        </tr>
        </thead>
        @if(count($rewards) > 0)

            <tbody>

            @foreach($rewards as $c)
                <tr>
                    <td>{!! $c->id !!}</td>
                    <td>{!! $c->active !!}</td>
                    <td>{!! $c->name !!}</td>
                    <td>{!! $c->description !!}</td>
                    <td>{!! $c->points !!}</td>
                    <td>
                        <a href="{!! url('/admin/rewards/'.$c->id.'/edit') !!}" class="btn btn-default">Edit</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE', 'url' =>  url('/admin/rewards/'.$c->id)]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-default pull-left']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

            @endif
            </tbody>
    </table>

@endsection