@extends('shared.layout')

@section('body')
    <div class="hero hero-txt">
        <div class="container">
            <h1 class="hero-heading">Contact us</h1>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">{{ Session::get('success') }}</div>
        @else
            {!! Form::open(array('url' => '/contact', 'method' => 'post', 'class' => 'col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2','style' => '')) !!}
            <div class="panel panel-default networks">
                <div class="panel-heading">Contact us</div>
                <div class="panel-body">
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
                        {!! Form::label('name', 'Your Name', array()) !!}
                        {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Your Name')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Your Email', array()) !!}
                        {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter Email')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('subject', 'Subject', array()) !!}
                        {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'Subject')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('message', 'Your Message', array()) !!}
                        {!! Form::textarea('message', null, array('class' => 'form-control', 'placeholder' => 'Type your message here')) !!}
                    </div>

                </div>
            </div>
            {!! Form::submit('Submit', array('class' => 'btn btn-primary btn-lg pull-right')) !!}
            {!! Form::close() !!}

        @endif
    </div>
@endsection