@extends('shared.layout')

@section('body')
<div class="hero hero-auth py-6">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-12 text-center mx-auto">
            <h1 class="fw-800">Account Inaccessible</h1>
            <p>Please see the reason below.</p>
        </div>
    </div>
</div><!-- End .hero -->


<div class="container py-6">
    <div class="alert alert-danger">{!! $middleware_error !!}</div>
</div>
@endsection
