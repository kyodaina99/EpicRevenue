@extends('admin.shared.layout')

@section('body')

    {!! Form::open(array('url' => '/admin/campaigns/rates', 'method' => 'post')) !!}
        <table cellpadding="3" cellspacing="3">
            <tr>
                <td><b>Publisher ID:</b></td>
                <td>{!! Form::number('user_id', null, array('required' => 'required')) !!}</td>
            </tr>
            <tr>
                <td valign="top"><b>Select campaign(s):</b></td>
                <td>
                    {!! Form::select('campaigns[]', $campaigns->pluck('name', 'id'), null, array('multiple', 'required' => 'required', 'style' => 'width: 500px; height: 300px;')) !!}
                </td>
            </tr>
            <tr>
                <td><b>New Rate:</b></td>
                <td>{!! Form::number('rate', '0.00', array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01', 'required' => 'required')) !!}</td>
            </tr>
            <tr>
                <td></td>
                <td>{!! Form::submit('Add Adjustment') !!}</td>
            </tr>
        </table>
    {!! Form::close() !!}<br /><br />
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Publisher</th>
            <th>Campaign</th>
            <th>Date</th>
            <th>Our Rate</th>
            <th>Rate Reason</th>
            <th>New Rate and Update</th>
        </tr>
        <tbody>
            @if($rates->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;">There are no custom rates.</td>
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
                        <td>{!! $r->user->id !!} -- {!! $r->user->firstname !!} {!! $r->user->lastname !!}</td>
                        <td>{!! $r->campaign->name !!}</td>
                        <td>{!! $r->updated_at !!}</td>
                        <td>{!! $r->campaign->network_rate !!}</td>
                        <td>{!! $r->reason !!}</td>
                        <td>
                            {!! Form::open(array('url' => 'admin/campaigns/rates', 'method' => 'put')) !!}
                                {!! Form::hidden('return_path', 'admin/campaigns/rates') !!}
                                {!! Form::hidden('rate_id', $r->id) !!}
                                {!! Form::number('rate', $r->rate, array('class' => 'form-control', 'min' => '0.01', 'step' => '0.01', 'required' => 'required')) !!}
                                {!! Form::select('rate_status', [ 0 => 'Pending', 'yes' => 'Approved', 'no' => 'Denied'], $r->active) !!}
                                {!! Form::submit('Update') !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection