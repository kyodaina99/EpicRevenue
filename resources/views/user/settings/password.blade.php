@extends('shared.layout')

@section('body')
    <div class="hero hero-txt">
        <div class="container">
            <h1 class="hero-heading">Change Password</h1>
        </div>
    </div>
    <div class="page-container no-shadow no-border">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Change Password</div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                            {!! Form::open(array('url' => '/settings/updatePassword', 'method' => 'post'))!!}
                            <div class="form-group">
                                {!! Form::label('currentPassword', 'Current Password', array('class' => 'control-label')) !!}
                                {!! Form::password('currentPassword', array('class' => 'form-control', 'required'=>'required')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('password', 'New Password', array()) !!}
                                {!! Form::password('password', array('class' => 'form-control', 'required'=>'required')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'Confirm Password', array()) !!}
                                {!! Form::password('password_confirmation', array('class' => 'form-control', 'required'=>'required')) !!}
                            </div>
                            {!! Form::submit('Update Password', array('class' => 'btn btn-default')) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection