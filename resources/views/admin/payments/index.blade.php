@extends('admin.shared.layout')

@section('body')
    <b>Name color chart:</b><br />
    <i><font color="green">Green = Reached threshold</font></i><br />
    <i><font color="red">Red = Did not reach minimum</font></i><br /><br />
    {!! Form::open(['url' => '/admin/payments', 'method' => 'post']) !!}
    <table class="table reports">
        <tr>
            <th>Select</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Payment Method</th>
            <th>Payment Name/Email</th>
            <th>Payment Threshold</th>
            <th>Payment Amount</th>
            <th>Paid Amount</th>
            <th>Options</th>
        </tr>
        @if ($users->isEmpty())
            <tr>
                <td colspan="9" style="text-align:center;">There are no payments or earnings for your search.</td>
            </tr>
        @else
            @foreach ($users as $u)
                @php
                    $balance = $u->balance;
                    $cleared = $balance ? $balance->histories()->operationOf('add')->cleared()->sum('amount') - $balance->histories()->operationOf('withdraw')->sum('amount') : 0;
                    $paymentDetail = $u->userPaymentDetail;
                    $threshold = $paymentDetail ? $paymentDetail->threshold : 50;
                    $paymentMethod = $paymentDetail ? UserPaymentMethod::find($paymentDetail->payment_method_id) : null;
                @endphp
                @if ($cleared >= $threshold)
                    <tr>
                        <td>
                            {!! Form::checkbox('users[]', $u->id) !!}
                        </td>
                        <td>{!! $u->id !!}</td>
                        <td>
                            <i>
                                <font color="{{ $cleared <= (float) $threshold ? 'red' : 'green' }}">
                                    {!! $u->firstname . ' ' . $u->lastname !!}
                                </font>
                            </i>
                        </td>
                        <td>{{ $paymentMethod ? $paymentMethod->name : '' }}</td>
                        <td>{{ $paymentDetail ? $paymentDetail->q1 : '' }}</td>
                        <td>{!! number_format($threshold, 2) !!}</td>
                        <td>$ {!! $cleared !!}</td>
                        <td>$ {!! $balance ? $balance->histories()->operationOf('withdraw')->sum('amount') : 0 !!}</td>
                        <td><a href="{{ url('/admin/#/publishers/edit/' . $u->id) }}" target="_blank">View Account</a></td>
                    </tr>
                @endif
            @endforeach
        @endif
    </table><br />
    {!! Form::submit('Generate') !!}
    {!! Form::close() !!}
@endsection

