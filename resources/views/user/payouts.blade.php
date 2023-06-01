@extends('shared.layout')

@section('body')

    @unless($is_mobile)
        <div class="hero hero-dashboard">
            <div class="container">
                <div class="hero-stats">
                    <div class="hero-stat">
                        <h3>${!! number_format($unpaid,2)  !!}</h3>
                        <h5 class="font-dark-gray">Unpaid Earnings</h5>
                    </div>
                    <div class="hero-stat-border"></div>
                    <div class="hero-stat">
                        <h3>${!! number_format(($cleared),2) !!}</h3>
                        <h5 class="font-dark-gray">Cleared for Payment</h5>
                    </div>
                    <div class="hero-stat-border"></div>
                    <div class="hero-stat">
                        <h3>${!! number_format(($paid),2) !!}</h3>
                        <h5 class="font-dark-gray">Paid Earnings</h5>
                    </div>
                    <div class="hero-stat-border"></div>
                    <div class="hero-stat">
                        <h3>${!! number_format($lifetime,2) !!}</h3>
                        <h5 class="font-dark-gray">Lifetime Earnings</h5>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <div class="user-stats">
            <div class="user-stat-group top-border">
                <div class="user-stat">
                    <h3>${!! number_format($unpaid,2)  !!}</h3>
                    <h5 class="font-dark-gray">Unpaid Earnings</h5>
                </div>
                <div class="user-stat">
                    <h3>${!! number_format(($cleared),2) !!}</h3>
                    <h5 class="font-dark-gray">Cleared for Payment</h5>
                </div>
            </div>
            <div class="user-stat-group">
                <div class="user-stat">
                    <h3>${!! number_format(($paid),2) !!}</h3>
                    <h5 class="font-dark-gray">Paid Earnings</h5>
                </div>
                <div class="user-stat">
                    <h3>${!! number_format($lifetime,2) !!}</h3>
                    <h5 class="font-dark-gray">Lifetime Earnings</h5>
                </div>
            </div>
        </div>
    @endunless

    <div class="clearfix"></div>

    <div class="page-container no-shadow">
        <div class="container">
            <div class="row">
                @if(is_null($tax_details))
                    <a href="{!! url('/taxdetails') !!}" class="text-danger"><div class="alert alert-danger" role="alert">Our records show you haven’t submitted your tax information, Please submit it in order to be paid.</div></a>
                @endif
                <div class="font-gray"><strong>Heads up!</strong> Payments are sent out weekly to your selected payment method if the amount "CLEARED FOR PAYMENT" is above your set payment threshold.</div>

                <hr>
                <div class="col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Payouts</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                </tr>
                                @if(count($withdraws))
                                    @foreach($withdraws as $w)
                                        <tr>
                                            <td>{!! $w->amount !!}</td>
                                            <td>{!! $w->method !!}</td>
                                            <td>{!! $w->created_at !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No payments have been sent to you yet, Keep promoting.</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div><!--end grid_8-->
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Update payment information</div>
                        <div class="panel-body">
                            {{--Was there an error?--}}
                            @if(count($errors))
                                @foreach ($errors->all() as $error)
                                    <div class="notification-error">{!! $error !!}</div><br />
                                @endforeach
                            @elseif (isset($success))
                                <div class="notification-notice">{{ $success }}</div><br />
                            @endif
                            {!! Form::model(\App\Models\PaymentDetail::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->first(),
                            array('url' => 'payouts', 'method' => 'post')) !!}
                            <div class="form-group">
                                {!! Form::label('method', 'Payment Method') !!}
                                {!! Form::select('method', array('paypal' => 'PayPal', 'gift_card' => 'Gift Card', 'check' => 'Check'), null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('send_to', 'Pay to') !!}
                                {!! Form::text('send_to', null, array('class' => 'form-control')) !!}
                                <p class="help-block">PayPal email, Payee name, or BTC Address.</p>
                            </div>
                            <div class="form-group">
                                {!! Form::label('threshold', 'Payment Threshold') !!}
                                {!! Form::select('threshold', array(50 => '$50.00', 100 => '$100.00', 500 => '$500.00'), null, array('class' => 'form-control')) !!}
                            </div>
                            {!! Form::submit("Update payment info", array('class' => 'btn btn-default')) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <hr>
    </div>
@endsection