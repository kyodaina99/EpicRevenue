@extends('admin.shared.layout')

@section('body')
    You can search publishers using the below form.
    <form action="index.php" method="get">
        <table class="table table-striped table-bordered">
            <tr>
                <td><b>Search keyword:</b></td>
                <td><input type="text" name="search" /></td>
            </tr>
            <tr>
                <td><b>Search type:</b></td>
                <td>
                    <select name="type">
                        <option value="pid">Publisher ID</option>
                        <option value="puser">Publisher username</option>
                        <option value="pfname">Publisher First name</option>
                        <option value="plname">Publisher Last name</option>
                        <option value="pemail">Publisher Email Address</option>
                        <option value="pregip">Publisher Register IP</option>
                        <option value="pweburl">Publisher Website URL</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Search" /></td>
            </tr>
        </table>
        <br />
    </form>

    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Total Earned</th>
            <th>Total Paid</th>
            <th>Name</th>
            <th>Email</th>
            <th>Options</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{!! $user->id !!}</td>
                <td>{!! $user->approved !!}</td>
                <td>{!! $user->reports->where('status', 2)->sum('rate') !!}</td>
                <td></td>
                <td>{!! $user->firstname !!} {!! $user->lastname !!}</td>
                <td><a href="mailto:{!! $user->email !!}">{!! $user->email !!}</a></td>
                <td>
                    <a href="{!! url('/admin/publishers/' . $user->id) !!}" target="_blank" class="btn btn-default">View App</a>
                    <a href="{!! url('/admin/publishers/' . $user->id . '/edit') !!}" target="_blank" class="btn btn-default">View Account</a>
                    <a href="mass.php?pid='.$row['id'].'" target="_blank" class="btn btn-default">Email</a>
                </td>
            </tr>
        @endforeach
        {!! $users->render() !!}
    </table>
@endsection
