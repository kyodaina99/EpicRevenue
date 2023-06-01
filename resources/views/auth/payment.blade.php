@extends('shared.layout')

@section('body')
<div class="hero hero-auth">
        <div class="container">
            <center>
                <h2>Become a Epic Revenue Affiliate</h2>
                <p>Start promoting some of the top products and brand in as soon as 24 hours!</p>
            </center>

        </div>
    </div><!-- End .hero -->
<div class="container">
    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-lg-4 col-md-4 col-12 mx-auto">
            <!-- card -->
            <div class="px-4 py-3 py-lg-4 card rounded">
                {!! Form::open(array('url' => '/account/create/payment', 'method' => 'post', 'class' => 'form-register')) !!}
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
                    @if (isset($middleware_error))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! $middleware_error !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="panel panel-default networks">
                        <div class="panel-heading">How do you want to be paid?</div>
                        <div class="panel-body">
                            <div class="pay_option_panel row">
                                <div class="pay_option_div col-3">
                                    {!! Form::radio('payment_method', 'paypal') !!}
                                    <img src="{{ url('/images/register/paypal.png') }}" alt="Paypal" class="pay_option_img w-100"> Paypal
                                </div>
                                <div class="pay_option_div col-3">
                                    {!! Form::radio('payment_method', 'check') !!}
                                    <img src="{{ url('/images/register/cheque-icon.png') }}" alt="Cheque" class="pay_option_img w-100"> Check
                                </div>
                                <div class="pay_option_div col-3">
                                    {!! Form::radio('payment_method', 'gift_card') !!}
                                    <img src="{{ url('/images/register/gift-card.jpg') }}" alt="Gift Card" class="pay_option_img w-100"> Gift Card
                                </div>
                            </div>
                            <span id="description_txt">Details</span><span style="color: red">*</span>
                            <br />
                            {!! Form::text('payment_method_detail', null, array('class' => 'form-control', 'maxlength' => '255')) !!}
                            <br />
                        </div>
                    </div>
                    <div class="grid_12">
                        {!! Form::submit('Submit', array('class' => 'btn btn-primary btn-lg pull-right')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- !card -->
        </div>
        <!-- !col -->
    </div>
    <!-- !row -->
</div>
@endsection

@section('scripts')
    <script>
        function updateDetails() {
            str = $('input[name=payment_method]:checked', '#pay_option_panel').val();
            //myele = $('input[name=payment_method_detail]');
            myele = $('#description_txt');
            if (str=="paypal")
            {
                myele.html("Please type in your Paypal email");
            }
            else if (str=="check")
            {
                myele.html("Name check should be written to?");
            }
            else if (str=="gift_card")
            {
                myele.html("Which brand Gift Card do you want?");
            }
            else if (str=="bitcoins")
            {
                myele.html("Enter your Bitcoins Address");
            }
            else
            {
                myele.html("Please type in your address");
            }


        }

        $(document).ready(function () {
            $('img').click(function(){
                //$('input:radio[name=payment_method]').attr("checked", false);
                $(this).prev().click();
            });
        });

        $('#pay_option_panel input').on('change', function() {
            updateDetails();
        });
    </script>
@endsection
