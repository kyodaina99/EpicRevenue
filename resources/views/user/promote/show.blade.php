@extends('shared.layout')

@section('body')
    <div class="hero hero-dashboard">
        <div class="container">
            <h1 class="hero-heading">
                @<span class="upper">{!! $account->username !!}</span>
            </h1>
            <p class="hero-p">Available below are graphics and text provided by us or our Advertisers for you to promote on this account.</p>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="page-container no-shadow no-border">
        <div class="container">
            <h2>Available Promotions</h2>
            <hr>
            {{--<div class="alert alert-info">Unsure of how to post promo?--}}
            {{--<a target="_blank" href="http://blog.influencersreach.com/2015/07/27/how-to-post-a-promo-from-mobile-device/">--}}
            {{--Click here to view this tutorial.--}}
            {{--</a>--}}
            {{--</div>--}}
            @if(count($promotions) > 0)
                <div class="row">
                    <?php $count = 1; ?>
                    @foreach($promotions as $p)
                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="ig-post" style="text-align:left;">
                                        {!! Html::image('/promote/image/' . $p->id, 'picture', ['class' => 'img-responsive'])!!}
                                        <div class="ig-post-title"><b>BIO url:</b>
                                            <?php
                                            $url = $p->url;
                                            if( str_contains($url, '{pubid}') )
                                                $url = str_replace("{pubid}", auth()->user()->id, $url);
                                            ?>
                                            <input onClick="this.setSelectionRange(0, this.value.length)" class="form-control" type="text" value="{!! $url !!}" />
                                        </div>
                                        <div class="ig-post-title"><b>Optional Caption:</b>
                                            <textarea onClick="this.setSelectionRange(0, this.value.length)" class="form-control" rows="4" id="comment">{!! $p->description !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $count++ ?>
                        @if(($count % 4) == 1)
                            <div class="clearfix"></div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger">There are no specialized content available to post on this account yet. View our <a href="{!! url('/campaigns') !!}">campaigns</a> page to find products or services you can promote.</div>
            @endif
        </div>
    </div>
    <div class="container">
        <hr>
    </div>
@endsection