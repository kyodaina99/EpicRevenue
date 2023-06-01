@extends('admin.shared.layout')

@section('body')
    {!! Form::model($user, array('url' => '/admin/publishers/' . $user->id,'method' => 'put')) !!}
        <table class="table table-striped table-bordered">
            <tr>
                <td colspan="2"><h2>Personal Information</h2></td>
            </tr>
            <tr>
                <td><b>ID:</b></td>
                <td>{!! $user->id !!}</td>
            </tr>
            <tr>
                <td><b>Manager:</b></td>
                <td>
                    @if(is_null($user->approved_by))
                        Not approved
                    @else
                        {!! \App\User::find($user->approved_by)->firstname !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>First name:</b></td>
                <td>{!! Form::text('firstname', null) !!}</td>
            </tr>
            <tr>
                <td><b>Last name:</b></td>
                <td>{!! Form::text('lastname', null) !!}</td>
            </tr>
            <tr>
                <td><b>Email address:</b></td>
                <td>{!! Form::text('email', null) !!}</td>
            </tr>
            <tr>
                <td><b>Phone number:</b></td>
                <td>{!! Form::text('phone', null) !!}</td>
            </tr>
            <tr>
                <td><b>Address 1:</b></td>
                <td>{!! Form::text('address1', null) !!}</td>
            </tr>
            <tr>
                <td><b>Address 2:</b></td>
                <td>{!! Form::text('address2', null) !!}</td>
            </tr>
            <tr>
                <td><b>City:</b></td>
                <td>{!! Form::text('city', null) !!}</td>
            </tr>
            <tr>
                <td><b>State:</b></td>
                <td>{!! Form::text('state', null) !!}</td>
            </tr>
            <tr>
                <td><b>ZIP code:</b></td>
                <td>{!! Form::text('zip', null) !!}</td>
            </tr>
            <tr>
                <td colspan="2"><h2>Account statuses</h2></td>
            </tr>
            <tr>
                <td><b>Status:</b></td>
                <td>
                    {!! Form::select('approved', ['yes' => 'Approved', 'no' => 'Not Approved Yet'], null) !!}
                </td>
            </tr>
            <tr>
                <td><b>Email Status:</b></td>
                <td>
                    {!! Form::select('email_confirmed', ['yes' => 'Confirmed', 'no' => 'Not Confirmed'], $user->status->email_confirmed) !!}
                </td>
            </tr>
            <tr>
                <td><b>Role:</b></td>
                <td>
                    {!! Form::select('role', ['1' => 'admin', '2' => 'user', '3' => 'business'], $user->role) !!}
                </td>
            </tr>
            <tr>
                <td colspan="2"><h2>Website Information</h2></td>
            </tr>
            <tr>
                <td><b>Website URL:</b></td>
                <td><input type="text" name="webURL" size="40" value="" /></td>
            </tr>

            <tr>
                <td colspan="2"><h2>Other</h2></td>
            </tr>
            <tr>
                <td><b>Lock tax:</b></td>
                <td><input type="checkbox" name="lockTax" value="1" /></td>
            </tr>
            <tr>
                <td></td>
                <td>{!! Form::submit('Update Information') !!}</td>
            </tr>

            <tr>
                <td colspan="2"><h2>Today Stats</h2></td>
            </tr>
            <tr>
                <td><b>Today Raw Clicks:</b></td>
                <td>{!! $today_clicks !!}</td>
            </tr>
            <tr>
                <td><b>Today Unique Clicks:</b></td>
                <td>{!! $today_unique_clicks !!}</td>
            </tr>

            <tr>
                <td><b>Today Leads:</b></td>
                <td>{!! $today_leads + $today_reversals !!}</td>
            </tr>
            <tr>
                <td><b>Today Conversion Rate:</b></td>
                <td>
                    @if($today_clicks + $today_leads === 0)
                        0
                    @else
                        {!! number_format($today_leads / ($today_clicks + $today_leads), 2) !!}
                    @endif
                    %
                </td>
            </tr>
            <tr>
                <td><b>Today Unique Clicks Conversion Rate:</b></td>
                <td>
                    @if($today_clicks + $today_leads === 0)
                        0
                    @else
                        {!! number_format($today_leads / ($today_unique_clicks + $today_leads), 2) !!}
                    @endif
                    %
                </td>
            </tr>


            <tr>
                <td colspan="2"><h2>Earnings Stats</h2></td>
            </tr>
            <tr>
                <td><b>Todays Earnings:</b></td>
                <td>${!! $today_earnings !!}</td>
            </tr>
            <tr>
                <td><b>Months Earnings:</b></td>
                <td>${!! $month_earnings !!}</td>
            </tr>
            <tr>
                <td><b>Last Months Earnings:</b></td>
                <td>${!! $lastMonth_earnings !!}</td>
            </tr>
            <tr>
                <td><b>Total Earnings:</b></td>
                <td>${!! $total_earnings !!}</td>
            </tr>


            <tr>
                <td colspan="2"><h2>Campaign Stats</h2></td>
            </tr>
            <tr>
                <td><b>Raw Clicks:</b></td>
                <td>{!! $campaign_clicks !!}</td>
            </tr>
            <tr>
                <td><b>Unique Clicks:</b></td>
                <td>{!! $campaign_unique_clicks !!}</td>
            </tr>
            <tr>
                <td><b>Leads:</b></td>
                <td>{!! $campaign_leads + $campaign_reversals !!}</td>
            </tr>
            <tr>
                <td><b>Reversals:</b></td>
                <td>{!! $campaign_reversals !!}</td>
            </tr>
            <tr>
                <td><b>Conversion Rate:</b></td>
                <td>
                    @if($campaign_unique_clicks + $campaign_leads <= 0)
                        0
                    @else
                        {!! number_format($campaign_leads / ($campaign_clicks + $campaign_leads), 2) !!}
                    @endif
                    %
                </td>
            </tr>
            <tr>
                <td><b>Unique Clicks Conversion Rate:</b></td>
                <td>
                    @if($campaign_unique_clicks + $campaign_leads <= 0)
                        0
                    @else
                        {!! number_format($campaign_leads / ($campaign_unique_clicks + $campaign_leads), 2) !!}
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
                <td>% (0 Proxies Caught)</td>
            </tr>
            <tr>
                <td><b>Yesterdays Proxy Rate:</b></td>
                <td>% (0 Proxies Caught)</td>
            </tr>
            <tr>
                <td><b>Overall Proxy Rate:</b></td>
                <td></td>
            </tr>
        </table>
    {!! Form::close() !!}<br />

    <h2>Last 5 Reports (Clicks, Leads and Reversals)</h2>

    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Campaign name</th>
            <th>Credit hash</th>
            <th>Date</th>
        </tr>
        @if($last_reports->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center;">There are no publisher campaign reports.</td>
            </tr>
        @else
            @foreach($last_reports as $report)
                <tr>
                    <td>{!! $report->id !!}</td>
                    <td>
                        @if($report->status == 1)
                            Click
                        @elseif($report->status == 2)
                            Lead
                        @elseif($report->status == 3)
                            Reversal
                        @endif
                    </td>
                    <td>
                        @if(is_null($report->campaign))
                            Unknown
                        @else
                            {!! $report->campaign->name !!}
                        @endif
                    </td>
                    <td>{!! $report->credit_hash !!}</td>
                    <td>{!! $report->created_at !!}</td>
                </tr>
            @endforeach
        @endif
    </table><br />

    <h2>Campaign Rate Adjustment(s)</h2>
		<table class="table table-striped table-bordered">
		<tr>
			<th>ID</th>
			<th>Status</th>
			<th>Campaign</th>
			<th>Date</th>
			<th>Our Rate</th>
			<th>New Rate and Update</th>
		</tr>
        @if($rates->isEmpty())
            <tr>
                <td colspan="6" style="text-align: center;">There are no custom rate adjustments for this account.</td>
            </tr>
        @else
            @foreach($rates as $r)
                <tr>
                    <td>{!! $r->id !!}</td>
                    <td>
                        @if(is_null($r->active))
                            Pending
                        @elseif($r->active === 'yes')
                            Active
                        @elseif($r->active === 'no')
                            Not Active
                        @else
                            Unknown (Unexpected Behaviour)
                        @endif
                    </td>
                    <td>{!! $r->campaign->name !!}</td>
                    <td>{!! $r->created_at !!}</td>
                    <td>{!! $r->campaign->network_rate !!}</td>
                    <td>
                        {!! Form::open(array('url' => 'admin/campaigns/rates', 'method' => 'put')) !!}
                            {!! Form::hidden('return_path', 'admin/publishers/'. $user->id .'/edit') !!}
                            {!! Form::hidden('rate_id', $r->id) !!}
                            {!! Form::number('rate', $r->rate, array('required' => 'required')) !!}
                            {!! Form::select('rate_status', [ 0 => 'Pending', 'yes' => 'Approved', 'no' => 'Denied']) !!}
                            {!! Form::submit('Update') !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
		</table><br />

    <h2 style="color:red;">Account Fraud Alerts</h2>
		<table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Note</th>
                <th>Date</th>
		    </tr>
			<tr>
				<td colspan="3" style="text-align: center;">There are no fraud alerts for this account.</td>
			</tr>
        </table><br />

@endsection