@extends('shared.layout')

@section('body')
    <div class="hero hero-dashboard">
        <div class="container">
            <h1 class="hero-heading">Add Social Account</h1>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="page-container no-border">
        <div class="container">

            <form action="/networks" method="post" class="form-register networks col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
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
                        <div class="panel-heading">Add Social Account</div>
                        <div class="panel-body">
                            <div class="alert alert-info">Influencersreach does <b>NOT</b> collect any passwords associated with your social media accounts.</div>
                            <ul class="add-networks">
                                <li>
                                    <a id="instagram_btn" data-popup="true" class="network_tile instagram">
                                        <span class="fa fa-instagram"></span>
                                        <span class="title">Instagram</span>
                                        <!--<span class="niche-icon size-25 add" data-gravity="s" data-offset="20" data-toggle="tooltip" original-title="Add another account?"></span>-->
                                    </a>
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

            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <a class="btn btn-primary btn-lg" href="/promote">Go Back</a>
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

            $('#instagram_btn').click(function () {
                console.log('click');
                $('#igPanel').slideDown('slow');
            });

            $('#instagram_verify').click(function(){
                $( "#ig_result" ).html( "Verifying..." );

                var username = $('#ig_username').val();
                console.log('username: '+username);
                $.post( "/influencers/apply/networks/instagram/" + username , function( data )  {
                    if(data == 'success') {
                        $( "#ig_result" ).removeClass("alert alert-danger");
                        $( "#ig_result" ).addClass("alert alert-success");
                        $( "#ig_result" ).html( "Your instagram account("+ username +") is added and verified successfully." );
                    } else {
                        $( "#ig_result" ).removeClass("alert alert-success");
                        $( "#ig_result" ).addClass("alert alert-danger");
                        $( "#ig_result" ).html( "We are unable to verify your account " + username + "." );
                    }
                });

            });
        });
    </script>
@endsection