@extends('shared.layout')

@section('body')
    <div class="hero hero-txt">
        <div class="container">
            <h1 class="hero-heading">Get Rewards When You Monetize With Us!</h1>
            @unless(auth()->user()->role == 1 || auth()->user()->role == 2)
                <h4>Along with our weekly and monthly contest, Our influencers have the ability to use points earned from getting leads, inviting people, coupon codes we randomly give out and more to earn points which they can then use to redeem rewards below.</h4>
            @endunless
        </div>
    </div><!-- End .hero -->
    <div class="clearfix"></div>
    <div class="container" style="height:30px;"></div>
    <div class="container">
        @if(count($rewards)> 0)
            <div class="row">
                @foreach($rewards as $r)
                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3 class="panel-title">{!! $r->name !!}</h3></div>
                            <div class="panel-body">
                                <div class="reward-img">{!! Html::image('/images/rewards/'. $r->image, 'picture', ['class' => 'img-responsive']) !!} <br /></div>
                                <p>{!! $r->description !!}</p>
                                @if(auth()->user()->role == 1 || auth()->user()->role == 2)
                                    <p><strong>Points Required: </strong>{!! $r->points !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="clearfix"></div>
        @else
            <div class="clearfix"></div>
            <div class="alert alert-info">Rewards Coming Soon</div>
        @endif
    </div>
@endsection