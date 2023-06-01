@extends('shared/layout')

@section('body')
<div class="hero hero-auth py-6">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-12 text-center mx-auto">
            <h1 class="fw-800">Create an Account</h1>
            <p>Create an Epic Revenue start promoting, or earning today!</p>
        </div>
    </div>
</div><!-- End .hero -->

<div class="container">
    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-lg-5 col-md-6 py-6 col-12 mx-auto">
            <!-- card -->
            <div class="px-4 py-3 py-lg-4 mb-0 card rounded">
            <!--
            <ul id='timeline'>
                <span id='timeline2' style="width:25%"></span>
                <li class='work'>
                    <input class='radio' id='work5' name='works' type='radio' checked>
                    <div class="relative">
                        <span class='date checked'>Account Details</span>
                        <span class='circle checked'>1</span>
                    </div>
                </li>
                <li class='work'>
                    <input class='radio' id='work4' name='works' type='radio'>
                    <div class="relative">
                        <span class='date'>Address</span>
                        <span class='circle'>2</span>
                    </div>
                </li>
                <li class='work'>
                    <input class='radio' id='work3' name='works' type='radio'>
                    <div class="relative">
                        <span class='date'>Payment Method</span>
                        <span class='circle'>3</span>
                    </div>
                </li>
            </ul>
            -->
            {!! Form::model($user, array(
                'url' => '/account/create', 
                'method' => 'post', 
                'class' => '',
                'style' => '',
                'id' => 'registerForm'
            )) !!}
            <div class="panel panel-default networks">
                <div class="panel-body">
                    {{-- Was there an error? --}}
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger mb-2">{{ $error }}</div>
                        @endforeach
                    @endif

                    <div class="form-group">
                        <!-- {!! Form::label('firstname', 'Firstname', array()) !!} -->
                        {!! Form::text('firstname', null, array('class' => 'form-control', 'placeholder' => 'First name')) !!}
                    </div>
                    <div class="form-group">
                        <!-- {!! Form::label('lastname', 'Lastname', array()) !!} -->
                        {!! Form::text('lastname', null, array('class' => 'form-control', 'placeholder' => 'Last name')) !!}
                    </div>
                    <div class="form-group">
                        <!-- {!! Form::label('email', 'Email', array()) !!} -->
                        {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email address')) !!}
                    </div>
                    <div class="form-group">
                        <!-- {!! Form::label('password', 'Password', array()) !!} -->
                        {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Pasword')) !!}
                    </div>
                    <div class="form-group">
                        <!-- {!! Form::label('password_confirmation', 'Confirm Password', array()) !!} -->
                        {!! Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) !!}
                    </div>
                    
                    <div class="g-recaptcha" data-sitekey="{{config('recaptcha.api_site_key','site_key')}}"></div>
                    
                    <div class="form-group">
                    {!! Form::checkbox('terms', null, false) !!}&nbsp; I have <b>read</b> and <b>agree</b> to the <a href="{{ url('/terms') }}" target="_blank" title="Terms of Service">Terms of Service</a>.
                    </div>
                    <div class="form-group">
                    {!! Form::checkbox('privacy', null, false) !!}&nbsp; I have <b>read</b> and <b>agree</b> to the <a href="{{ url('/privacy') }}" target="_blank" title="Privacy Policy">Privacy Policy</a>.
                    </div>
                </div>
            </div>
            {!! Form::submit('Next', array('class' => 'btn btn-primary pull-right')) !!}
            {!! Form::close() !!}

            </div>
            <!-- !card -->
        </div>
        <!-- !col -->
    </div>
    <!-- !row -->
</div>

@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
