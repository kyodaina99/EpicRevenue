@extends('shared.layout')

@section('body')
    <div class="hero small">
        <div class="container">
            <h1 class="hero-heading">Become a Affiliate</h1>
        </div>
    </div>
    <div class="page">
        <div class="container">
            <ul id='timeline'>
                <div id='timeline2' style="width:60%"></div>
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
                        <span class='date checked'>Networks</span>
                        <span class='circle checked'>2</span>
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

            <form action="/account/create/networks" method="post" class="form-register networks col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="">

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
                    @if (isset($error))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($error as $e)
                                    <li>{!! $e !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel panel-default networks">
                        <div class="panel-heading">Add Networks</div>
                        <div class="panel-body">
                            <div class="alert alert-info">AdsAndAffiliates does <b>NOT</b> collect any passwords associated with your social media accounts.</div>
                            <ul class="add-networks">
                                <li>
                                    @if(empty(session('instagram_name')))
                                        <a id="instagram_btn" data-popup="true" class="network_tile instagram">
                                            <span class="fa fa-instagram"></span>
                                            <span class="title">Instagram</span>
                                            <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                        </a>
                                    @else
                                        <p>Connected as {{ session('instagram_name') }}</p>
                                    @endif
                                </li>
                                <li>
                                    <a id="facebook_btn" data-popup="true" class="network_tile facebook disabled" href="#">
                                        <span class="fa fa-facebook"></span>
                                        <span class="title">Facebook</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
                                </li>
                                <li>
                                    <a id="twitter_btn" data-popup="true" class="network_tile twitter disabled" href="#">
                                        <span class="fa fa-twitter"></span>
                                        <span class="title">Twitter</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
                                </li>
                                <li>
                                    <a data-popup="true" class="network_tile twitter disabled" href="#">
                                        <span class="fa fa-youtube"></span>
                                        <span class="title">Youtube</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
                                </li>
                                <li>
                                    <a data-popup="true" class="network_tile twitter disabled" href="#">
                                        <span class="fa fa-tumblr"></span>
                                        <span class="title">Tumblr</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
                                </li>
                                <li>
                                    <a data-popup="true" class="network_tile twitter disabled" href="#">
                                        <span class="fa fa-vine"></span>
                                        <span class="title">Vine</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    {{--<a href="{{ url('/register/payment') }}" class="btn btn-default">Skip</a>--}}
                </div>
            </form>

            <div class="clearfix"></div>

            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" id="igPanel" style="display: none;">
                <div class="panel panel-default networks">
                    <div class="panel-heading">Add Instagram account</div>
                    <div class="panel-body">
                        <p>Please set your BIO url to “http://reachurl.com/verify/ig/{!! auth()->user()->id !!}” and click verify so we can confirm account ownership, You may remove or change it back afterwards.</p>
                        <div class="form-stacked">
                            <div class="form-group">
                                {!! Form::text('ig_username', null, array('id' => 'ig_username','class' => 'form-control' ,'placeholder' => 'Instagram username')) !!}
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <button class="btn btn-primary" id ="instagram_verify">Verify</button>
                            </div>
                        </div>
                        <div id="ig_result"></div>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>

            <div id="next" class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" style="display: none;">
                <a class="btn btn-primary btn-lg pull-right" href="/account/create/payment">Next</a>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });




        });
    </script>
@endsection
