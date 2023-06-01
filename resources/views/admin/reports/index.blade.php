@extends('admin.shared.layout')

@section('body')
    <form action="reports.php" method="get">
        <table class="table reports">
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>PID</th>
                <th>Name</th>
                <th>Date</th>
                <th>OS</th>
                <th>GEO</th>
                <th>Credit hash</th>
                <th>Options</th>
            </tr>
            @if($reports->isEmpty())
                <tr>
                    <td colspan="10" style="text-align: center;">There are no reports.</td>
                </tr>
            @else
                @foreach($reports as $r)
                    <tr>
                        <td>{!! $r->id !!}</td>
                        <td>
                            @if($r->status == 1)
                                Click
                            @elseif($r->status == 2)
                                Lead
                            @elseif($r->status == 3)
                                Reversal
                            @endif
                        </td>
                        <td><a href="{!! url('/admin#/publishers/edit/' . $r->user_id) !!}" target="_blank">{!! $r->user_id !!}</a></td>
                        <td>
                            @if(is_null($r->campaign))
                                Unknown (Campaign Deleted Or any other Bug)
                            @else
                                {!! $r->campaign->name !!}
                            @endif
                        </td>
                        <td>{!! $r->created_at->toDateTimeString() !!}</td>
                        <td>
                            <?php $agent = new \Jenssegers\Agent\Agent();
                                $agent->setUserAgent($r->user_agent);
                            ?>
                            {!! $agent->platform() !!}
                        </td>
                        <td>{!! $r->country !!}</td>
                        <td>{!! $r->credit_hash !!}</td>
                        <td>
                            @if($r->status == 1)
                                <a href="{!! url('/admin/reports/options', ['id' => $r->id, 'status' => 2]) !!}" class="btn btn-success">Credit&nbsp;&nbsp;&nbsp;</a>
                            @elseif($r->status == 2)
                                <a href="{!! url('/admin/reports/options', ['id' => $r->id, 'status' => 1]) !!}" class="btn btn-danger">Reverse&nbsp;&nbsp;&nbsp;</a>
                            @endif
                            <a href="{!! url('/admin/reports/' . $r->id) !!}" class="btn btn-info">View Details</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </form>
    {!! $reports->render() !!}
@endsection