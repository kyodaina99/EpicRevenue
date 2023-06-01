@extends('shared.layout')

@section('body')
    <div class="hero hero-txt">
        <div class="container">
            <h1 class="hero-heading">Registration Successful!</h1>
        </div>
    </div>

    <div class="clearfix"></div>
<div class="page-container dashboard no-border">
    <div class="container">
        <div class="container-fluid">
            <div class="alert alert-success">{!! $message !!}</div>
        </div>
    </div>
</div>
@endsection