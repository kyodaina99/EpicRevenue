@extends('admin.shared.layout')

@section('body')
    <table class="table reports">
        <tr>
            <td><b>Report ID:</b></td>
            <td>{!! $report->id !!}</td>
        </tr>
        <tr>
            <td><b>Publisher:</b></td>
            <td><a href="{!! url('/admin#/publishers/edit/' . $report->user->id) !!}" target="_blank">{!! $report->user->firstname . ' ' . $report->user->lastname !!}</a></td>
        </tr>
        <tr>
            <td><b>Campaign name:</b></td>
            <td>
                @if(is_null($report->campaign))
                    Unknown (Campaign Deleted Or any other Bug)
                @else
                    {!! $report->campaign->name !!}
                @endif
            </td>
        </tr>
        <tr>
            <td><b>Rate:</b></td>
            <td>$ {!! $report->rate !!}</td>
        </tr>
        <tr>
            <td><b>Report Status:</b></td>
            <td>
                @if($report->status == 1)
                    Click
                @elseif($report->status == 2)
                    Lead
                @elseif($report->status == 3)
                    Reversal
                @endif
            </td>
        </tr>
        <tr>
            <td><b>Date:</b></td>
            <td>{!! $report->created_at !!}</td>
        </tr>
        <tr>
            <td><b>IP Address:</b></td>
            <td>{!! $report->ip !!}</td>
        </tr>
        <tr>
            <td><b>Internet Browser:</b></td>
            <td>
                <?php $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent($report->user_agent);
                ?>
                {!! $agent->browser() !!}
            </td>
        </tr>
        <tr>
            <td><b>Ref URL:</b></td>
            <td>{!! $report->ref_url !!}</td>
        </tr>
        <tr>
            <td><b>SubID1:</b></td>
            <td>{!! $report->subid1 !!}</td>
        </tr>
        <tr>
            <td><b>SubID2:</b></td>
            <td>{!! $report->subid2 !!}</td>
        </tr>
        <tr>
            <td><b>SubID3:</b></td>
            <td>{!! $report->subid3 !!}</td>
        </tr>
        <tr>
            <td><b>SubID4:</b></td>
            <td>{!! $report->subid4 !!}</td>
        </tr>
        <tr>
            <td><b>SubID5:</b></td>
            <td>{!! $report->subid5 !!}</td>
        </tr>
        <tr>
            <td><b>Credit Hash:</b></td>
            <td>{!! $report->credit_hash !!}</td>
        </tr>
    </table>
@endsection