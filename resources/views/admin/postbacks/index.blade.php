@extends('admin.shared.layout')

@section('body')
    Below are all custom postback networks that were created. To create a new one, <a href="{!! url('/admin/postbacks/create') !!}">click here</a>.<br /><br />
    <table class="table reports">
        <tr>
            <th>ID</th>
            <th>Network Name</th>
            <th>Postback URL</th>
            <th>Options</th>
        </tr>
        @if($postbacks->isEmpty())
            <tr>
                <td colspan="6" style="text-align: center;">There are no custom networks created.</td>
            </tr>
        @else
            @foreach($postbacks as $p)
                <tr>
                    <td>{!! $p->id !!}</td>
                    <td>{!! $p->name !!}</td>
                    <td>{!! url('/track/postback/' . $p->veri_slot) !!}</td>
                    <td>
                        <a href="{!! url('/admin/postbacks/'.$p->id.'/edit') !!}" class="btn btn-default">Edit</a>
                        <a href="{!! url('/admin/postbacks/'.$p->id.'/delete') !!}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this postback?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
@endsection
