@extends('shared/layout')
@section('body')
<div class="hero hero-auth py-6">
    <div class="container">
        <div class="col-lg-4 col-md-4 col-12 text-center mx-auto">
            <h1 class="fw-800">Welcome back!</h1>
            <p>Login to start promoting some of the top products and brands.</p>
        </div>
    </div>
</div><!-- End .hero -->

<div class="container">
    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-lg-4 col-md-4 col-12 py-6 mx-auto">
            <!-- card -->
            <div class="px-4 py-3 py-lg-4 card mb-0 rounded">
                <form class="form-horizontal form-login" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <!-- <label class="fw-700 mb-2">Email Address</label> -->
                        @if ($errors->has('email'))
                        <div class="alert alert-danger mb-2">{{ $errors->first('email') }}</div>
                        @endif
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email address" />
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <!-- <label class="fw-700 mb-2">Password</label> -->
                        @if ($errors->has('password'))
                        <div class="alert alert-danger mb-2">{{ $errors->first('password') }}</div>
                        @endif
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label><input type="checkbox" name="remember"> Remember Me</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a class="link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    </div>
                </form>
            </div>
            <!-- !card -->
        </div>
        <!-- !col -->
    </div>
    <!-- !row -->
</div>
@endsection
