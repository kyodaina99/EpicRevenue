@extends('admin.shared.layout')

@section('body')

You can search campaigns.
<form action="index.php" method="get">
<table class="table reports">
<tr>
	<td><b>Search keyword:</b></td>
	<td><input type="text" name="search" /></td>
</tr>
<tr>
	<td><b>Search type:</b></td>
	<td>
		<select name="type">
			<option value="cname">Campaign Name</option>
			<option value="cid">Campaign ID</option>
			<option value="cnetwork">Campaign Network</option>
		</select>
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="Search" /></td>
</tr>
</table><br />
</form>

Below are all campaigns added to the network.<br /><br />

<table class="table reports">
    <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Name</th>
        <!--<th>Date added</th>-->
        <th>Clicks</th>
        <th>Leads</th>
        <th>Reversals</th>
        <th>CR</th>
        <th>Unique CR</th>
        <th>Estimated Profit</th>
        <th>Network</th>
        <th>Options</th>
    </tr>
    @if(count($campaigns))
        @foreach($campaigns as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->active  }}</td>
                <td>{{ $c->name }}</td>
                <?php
                    $clicks = $c->reports()->click()->count();
                    $unique_clicks = $c->reports()->click()->get()->unique(function ($item) { return $item['campaign_id']. ' ' .$item['ip']; })->count();
                    $leads = $c->reports()->lead()->count();
                    $reversals = $c->reports()->reversal()->count();
                ?>
                <td>{!! $clicks !!}</td>
                <td>{!! $leads !!}</td>
                <td>{!! $reversals !!}</td>
                <td>
                    @if($leads + $clicks <= 0)
                        0
                    @else
                        {!! number_format($leads / ($leads + $clicks) * 100, 2) !!}
                    @endif
                    %
                </td>
                <td>
                    @if($leads + $unique_clicks <= 0)
                        0
                    @else
                        {!! number_format($leads / ($leads + $unique_clicks) * 100, 2) !!} 
                    @endif
                    %
                </td>
                <td>
                    $ {!! number_format(($leads * $c->network_rate) - ($leads * $c->rate), 2) !!}
                </td>
                <td>{{ $c->network->name }}</td>
                <td>
                    {{-- <a href="{{ url('/admin/campaigns/'. $c->id . '/edit' ) }}" class="btn btn-default">Edit</a>
                    <a href="{{ url('/admin/campaigns/'. $c->id . '/creatives' ) }}" class="btn btn-info">Creatives</a>
                    <a href="{{ url('/admin/campaigns/'. $c->id . '/private' ) }}" class="btn btn-default">Privates</a> --}}
                    <a href="{{ url('/admin/campaigns/'. $c->id . '/edit' ) }}" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#">Creatives</a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10" style="text-align: center;">There are no campaigns added to the system.</td>
        </tr>
    @endif
</table>

{!! $campaigns->render() !!}

@endsection
