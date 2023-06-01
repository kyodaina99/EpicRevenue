@extends('shared/layout')

@section('body')
 
<div class="hero main-promo text-white border-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h1 class="pb-2">Monetize the reach of your following</h1>
                <h4 class="col-lg-8 pb-2">Find great brands, products, and services to promote.</h4>
                <a href="{{ url('/account/create') }}" class="hero-apply-bttn btn btn-lg btn-primary">Become an Affiliate</a>
            </div>
        </div>
    </div>
</div><!-- End .hero -->
<div class="hero info-promo py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="p-2">
                    <div class="black rounded p-6">
                        <img src="https://epicrevenue.com/assets/img/influencers.jpg" class="w-100 rounded" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-10 mx-auto">
                <div class="pt-8">
                    <h3 class="fw-700 fs-30 mb-4">Popular fashion and beauty brands are experiencing explosive growth online with influencers.</h3>
                    <p class="fs-18">Influencers offer fashion and beauty brands a powerful advantage online, with their wide reach, relatability, and ability to create engaging content. By tapping into their influence, brands can leverage authenticity, inspire trends, and harness the social proof to drive explosive growth in the digital space.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hero info-promo border-top py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-10 mx-auto">
                <div class="pt-8">
                    <h3 class="fw-700 fs-30 mb-4">Promoting health and wellness products has become increasingly effortless with the support of affiliates and influencers.</h3>
                    <p class="fs-18">Affiliates and influencers have revolutionized the promotion of health and wellness products. With their wide networks, genuine endorsements, and persuasive content, they effortlessly connect brands with target audiences. This partnership facilitates the spread of awareness, boosts credibility, and drives exponential growth in the health and wellness industry.</p>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="p-2">
                    <div class="blue rounded p-6">
                        <img src="https://epicrevenue.com/assets/img/health.png" class="w-100 rounded" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hero info-promo border-top py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="p-2">
                    <div class="black rounded p-6">
                        <img src="https://epicrevenue.com/assets/img/food.png" class="w-100 rounded" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-10 mx-auto">
                <div class="pt-8">
                    <h3 class="fw-700 fs-30 mb-4">We offer affiliates and influencers a wide variety of food and entertainment offers to enhance audience engagement and collaboration.</h3>
                    <p class="fs-18">Our platform offers affiliates and influencers a vast range of food and entertainment offers. From exclusive dining experiences to captivating events, these opportunities enable influencers to engage their audience with irresistible promotions, strengthening brand partnerships and fostering loyal communities.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hero info-promo border-top py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-10 mx-auto">
                <div class="pt-8">
                    <h3 class="fw-700 fs-30 mb-4">Our platform offers a multitude of affiliate and influencers promotions across multiple verticals.</h3>
                    <p class="fs-18">Our platform provides a diverse array of affiliate and influencer promotions across multiple verticals. From fashion and beauty to health and wellness, these offers empower affiliates and influencers to effectively monetize their online presence, driving engagement and boosting revenue. Join us to explore limitless possibilities and unlock new avenues for success.</p>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="p-2">
                    <div class="blue rounded p-6">
                        <img src="https://epicrevenue.com/assets/img/nyc.png" class="w-100 rounded" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="hero fifth-promo border-top">
    <div class="container text-center">
        <h2 class="py-6">Brands we've promoted</h2>
        <div class="row">

            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/ICM-Logo.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/booking.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/expedia.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/groupon.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/king.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/netflix.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100e" src="{{ url('/images/home/clients/nook.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/skout.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/wordswithfriends.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/amazon.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/pocket.png') }}" alt=""/></div>
            <div class="col-md-2 col-sm-3 col-xs-6 brand"><img class="w-100" src="{{ url('/images/home/clients/dena.png') }}" alt=""/></div>

        </div>
    </div>
</div>
 -->
@endsection
