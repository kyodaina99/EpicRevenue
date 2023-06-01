@extends('shared/layout')

@section('body')
    <div class="hero small">
        <div class="container_12">
            <h1 class="semibold hero_heading">Forgot login details</h1>
        </div>
    </div>

    <div class="page">
        <div class="container_12 light">
            <div class="grid_6">
                {!! Form::open(array('url' => '/password/email', 'method' => 'post')) !!}
                    {{-- Was there an error? --}}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', null, array('class' => 'form-control')) !!}
                    </div>

                    {!! Form::submit('Send password Reset Link', array('class' => 'btn btn-default')) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection