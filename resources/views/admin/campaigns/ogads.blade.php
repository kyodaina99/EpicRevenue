@extends('admin.shared.layout')

@section('body')

    You can search campaigns.
    <form action="/admin/campaigns/ogads/import" method="get">
        <table class="table reports table-bordered">
            {{--<tr>--}}
                {{--<td><b>Search keyword:</b></td>--}}
                {{--<td><input type="text" name="search"  class="form-control"/></td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td><b>Search type:</b></td>--}}
                {{--<td>--}}
                    {{--<select name="type" class="form-control">--}}
                        {{--<option disabled selected value>None</option>--}}
                        {{--<option value="offerid">Offer ID</option>--}}
                        {{--<option value="name">Offer Name</option>--}}
                    {{--</select>--}}
                {{--</td>--}}
            {{--</tr>--}}
            <tr>
                <td><b>Device:</b></td>
                <td>
                    <select name="device" class="form-control">
                        <option selected value>All</option>
                        <option value="Desktop" @if(request()->input('device', null) == 'Desktop') selected @endif>Desktop</option>
                        <option value="iPhone" @if(request()->input('device', null) == 'iPhone') selected @endif>iPhone</option>
                        <option value="iPad" @if(request()->input('device', null) == 'iPad') selected @endif>iPad</option>
                        <option value="Android" @if(request()->input('device', null) == 'Android') selected @endif>Android</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Country:</b></td>
                <td>
                    <select name="country" class="form-control">
                        <option selected value>All</option>
                        @foreach($countries->pluck('code', 'iso2') as $iso2 => $code)
                            <option value="{{$iso2}}" @if(request()->input('country', null) == $iso2) selected @endif>{{$code}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn btn-default" type="submit" value="Filter/Search" /></td>
            </tr>
        </table><br />
    </form>

    Below are all offers that can be added to the network.<br /><br />

    <form method="post">
        <button type="submit" class="btn btn-primary">Click Here to Submit Selected Offers</button><br /><br />

        <table class="table table-responsive table-bordered reports">
            <tr>
                <th></th>
                <th>OFFER ID</th>
                <th>Picture</th>
                <th>Name</th>
                {{--<th>Description</th>--}}
                <th>Payout</th>
                <th>EPC</th>
                <th>Device</th>
                <th>Country</th>
                {{--<th>Link</th>--}}
            </tr>
            @if(count($offers))
                @foreach($offers as $offer)
                    <tr>
                        <td><input type="checkbox" name="offers[]" value="{{$offer->offerid}}" /></td>
                        <td>{{ $offer->offerid }}</td>
                        <td><img src="{{ $offer->picture  }}" alt="" width="100"></td>
                        <td>{{ $offer->name }}</td>
                        <td>{!! $offer->payout  !!}</td>
                        <td>{!! $offer->epc !!}</td>
                        <td>{{ $offer->device }}</td>
                        <td>{{ $offer->country }}</td>
                        <td>
                            {{--<a href="{{ url('/admin/campaigns/'. $c->id . '/edit' ) }}" class="btn btn-default">Edit</a>--}}
                            {{--<a href="{{ url('/admin/campaigns/'. $c->id . '/creatives' ) }}" class="btn btn-info">Creatives</a>--}}
                            {{--<a href="{{ url('/admin/campaigns/'. $c->id . '/private' ) }}" class="btn btn-default">Privates</a>--}}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10" style="text-align: center;">No offers found.</td>
                </tr>
            @endif
        </table>
    </form>
@endsection
