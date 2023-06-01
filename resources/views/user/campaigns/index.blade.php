@extends('shared.layout')
@section('body')

<div class="hero text-center py-6">
    <div class="container">
        @if(auth()->user()->role == 1 || auth()->user()->role == 2)
            <h1 class="hero-heading fw-700">Campaigns</h1>
            <p class="hero-p">Search this page for a campaign to promote on your account.</p>
        @else
            <div class="campaigns-join row">
                <div class="col-sm-8">
                    <span class="title">Influencers Reach is the best way to monetize your social accounts</span>
                    <p>Find services, products, apps and more you think will appeal to your following and make money everytime you promote.</p>
                </div>
                <div class="col-sm-1">
                    <div style="display:block;width:1px;">&nbsp;</div>
                </div>
                <div class="col-sm-3">
                    <a href="{{ url('/register') }}" class="btn btn-primary">Create your Free Account</a>
                    <span class="bttn-t">and get started in minutes</span>
                </div>
            </div>
        @endif
    </div>
</div>
    
<!-- search -->
<div class="search pt-6 pb-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                {!! Form::open(array('url' => '/campaigns/', 'method' => 'get')) !!}
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-lg-0 mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search... Ex product name" value="{{ request()->input('search', '') }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="mb-lg-0 mb-3">
                            {!! Form::select('country', $countries, request()->input('country'), array('id' => 'country', 'class' => 'form-select')) !!}
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 campaign_categories_mobile">
                        <div class="mb-lg-0 mb-3">
                            {!! Form::select('category', $categories->pluck('name', 'id'), request()->input('category', 0), array('id' => 'category', 'class' => 'form-select')) !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <input class="btn btn-primary w-100" type="submit" value="Sort" />
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>   
    </div>
</div>

<div class="campaigns pb-6">
        <div class="container">
            <div class="row">
                <div class="campaigns">
                    <div class="row">
                        @if(is_null($campaigns))
                            <div class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                No Campaigns Found!
                            </div>
                        @else
                            @if($campaigns->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    No Campaigns Found!
                                </div>
                            @endif
                            @foreach($campaigns as $campaign)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="{{ url('/campaign/' . $campaign->id) }}" class="text-black">
                                            ${{ $campaign->rate }}<small>/per lead</small>
                                        </a>    
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
    <a href="{{ url('/campaign/' . $campaign->id) }}">
        <img class="img-responsive border w-100" src="{{ $campaign->featured_img ? $campaign->featured_img->getImageOptimizedFullPath(200, 200) : '' }}" alt="{{ $campaign->name }}" />
    </a>
</div>

                                            <div class="col-lg-9">
                                            <a href="{{ url('/campaign/' . $campaign->id) }}">
                                                <h3 class="text-black py-2 mb-0 fs-18">{{ $campaign->name }}</h3>
                                                <div class="text-black opacity-50 mb-2">Category: {{ $campaign->category->name }}</div>
                                                <div class="text-black opacity-50">AVG. EPC: $0.44</div>
                                                <p class="py-2 mb-0 text-black d-none">{{ $campaign->description }}</p>
                                            </a>
                                            </div>
                                            @if(auth()->user()->role == 1 || auth()->user()->role ==2)
                                                <div class="card-body border-top pb-0 mt-3">
                                                    <div class="row">
                                                        <h5 class="col-12 text-left pb-2 fs-14 d-none" data-toggle="tooltip" data-placement="bottom" title="Amount you are paid for each valid conversion"><!--<b>Payment? </b>-->${{ $campaign->rate }}<small>/per lead</small></h5>
                                                        <div class="col-12">
                                                            <a href="{{ url('/campaign/' . $campaign->id) }}" class="btn btn-primary btn-md w-100">Promote Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
