@extends('shared/layout')

@section('body')
    <div class="hero hero-txt">
        <div class="container">
            <h1 class="hero-heading">Reset Password</h1>
        </div>
    </div>

    <div class="page">
        <div class="container_12 light">
            <div class="grid_6">
                {!! Form::open(array('url' => '/password/reset', 'method' => 'post')) !!}
                    <input type="hidden" name="token" value="{{ $token }}">
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
                        {!! Form::label('email', 'Email', array()) !!}
                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Password', array()) !!}
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Confirm Password', array()) !!}
                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                    </div>
                    {!! Form::submit('Reset Password', array('class' => 'btn btn-default')) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection