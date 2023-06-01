@extends('admin.shared.layout')

@section('body')
    <table class="table table-striped table-bordered">
        <tr>
            <td colspan="2"><h2>Options</h2></td>
        </tr>
        <tr>
            <td colspan="2"><h2>Personal Information</h2></td>
        </tr>
        <tr>
            <td><b>ID:</b></td>
            <td>{!! $user->id !!}</td>
        </tr>
        <tr>
            <td><b>Status:</b></td>
            <td>
                @if($user->approved === 'yes')
                    Approved   <a href="{!! url('/admin/publishers/' . $user->id . '/?approve=0') !!}">Disapprove</a>
                @else
                    Not Approved  <a href="{!! url('/admin/publishers/' . $user->id . '/?approve=1') !!}">Approve</a>
                @endif
            </td>
        </tr>
        <tr>
            <td><b>Full name:</b></td>
            <td>{!! $user->firstname !!} {!! $user->lastname !!}</td>
        </tr>
        <tr>
            <td><b>Email address:</b></td>
            <td><a href="mailto:{!! $user->email !!}">{!! $user->email !!}</a></td>
        </tr>
        <tr>
            <td><b>Phone number:</b></td>
            <td><a href="Callto://{!! $user->phone !!}">{!! $user->phone !!}</a></td>
        </tr>
        <tr>
            <td><b>Address 1:</b></td>
            <td>{!! $user->address1 !!}</td>
        </tr>
        <tr>
            <td><b>Address 2:</b></td>
            <td>{!! $user->address2 !!}</td>
        </tr>
        <tr>
            <td><b>City:</b></td>
            <td>{!! $user->city !!}</td>
        </tr>
        <tr>
            <td><b>State:</b></td>
            <td>{!! $user->state !!}</td>
        </tr>
        <tr>
            <td><b>ZIP code:</b></td>
            <td>{!! $user->zip !!}</td>
        </tr>

        <tr>
            <td colspan="2"><h2>Earnings Stats</h2></td>
        </tr>
        <tr>
            <td><b>Todays Earnings:</b></td>
            <td>{!! $today_earnings !!}</td>
        </tr>
        <tr>
            <td><b>Months Earnings:</b></td>
            <td>{!! $month_earnings !!}</td>
        </tr>
        <tr>
            <td><b>Total Earnings:</b></td>
            <td>{!! $total_earnings !!}</td>
        </tr>
        <tr>
            <td colspan="2"><h2>Campaign Stats</h2></td>
        </tr>
        <tr>
            <td><b>Clicks:</b></td>
            <td>{!! $clicks !!}</td>
        </tr>
        <tr>
            <td><b>Leads:</b></td>
            <td>{!! $leads !!}</td>
        </tr>
        <tr>
            <td><b>Reversals:</b></td>
            <td>{!! $reversals !!}</td>
        </tr>
        <tr>
            <td><b>Conversion Rate:</b></td>
            <td>
                @if($clicks + $leads <= 0)
                    0
                @else
                    {!! number_format($leads / ($clicks + $leads), 2) !!}
                @endif
                %
            </td>
        </tr>
        <tr>
            <td><b>Fraud/Reversal Rate:</b></td>
            <td>%</td>
        </tr>
        <tr>
            <td><b>Todays Proxy Rate:</b></td>
            <td>%</td>
        </tr>
        <tr>
            <td><b>Yesterdays Proxy Rate:</b></td>
            <td>%</td>
        </tr>
        <tr>
            <td><b>Overall Proxy Rate:</b></td>
            <td>%</td>
        </tr>
    </table>
@endsection
