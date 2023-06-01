@extends('shared/layout')

@section('body')
<div class="hero hero-auth py-6">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-12 text-center mx-auto">
            <h1 class="fw-800">Address</h1>
            <p>This will be used to send payments or information about your account.</p>
        </div>
    </div>
</div><!-- End .hero -->

<div class="container">
    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-lg-4 col-md-4 py-6 col-12 mx-auto">
            <!-- card -->
            <div class="px-4 py-3 py-lg-4 card mb-0 rounded">

            {!! Form::model($user, array('url' => '/account/create/address', 'method' => 'post', 'class' => '','style' => '')) !!}
            <div class="panel panel-default networks">
                <div class="panel-body">
                    {{-- Was there an error? --}}
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $errorr)
                            <div class="alert alert-danger">{{ $errorr }}</div>
                        @endforeach
                    @endif
                    @if (isset($error))
                            @foreach ($error as $e)
                                <div class="alert alert-danger">{!! $e !!}</div>
                            @endforeach
                    @endif

                    <div class="form-group">
                        {!! Form::label('address1', 'Address 1', array()) !!}
                        {!! Form::text('address1', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('address2', 'Address 2', array()) !!}
                        {!! Form::text('address2', null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('city', 'City', array()) !!}
                        {!! Form::text('city', null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('state', 'State', array()) !!}
                        {!! Form::text('state', null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('zip', 'Zip Code', array()) !!}
                        {!! Form::text('zip', null, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Phone Number', array()) !!}
                        {!! Form::text('phone', null, array('class' => 'form-control')) !!}
                    </div>
                    <br /><br />
                </div>
            </div>
            {!! Form::submit('Next', array('class' => 'btn btn-primary btn-lg pull-right')) !!}
            {!! Form::close() !!}
            </div>
            <!-- !card -->
        </div>
        <!-- !col -->
    </div>
    <!-- !row -->
</div>
@endsection
