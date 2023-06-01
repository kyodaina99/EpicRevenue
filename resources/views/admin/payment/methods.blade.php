@extends('admin.shared.layout')

@section('body')
    <h1>User Payment Methods</h1>
    <a href="{{ route('userPaymentMethods.create') }}">Add New</a>
    <ul>
        @foreach($userPaymentMethods as $userPaymentMethod)
            <li>
                {{ $userPaymentMethod->name }}
                <a href="{{ route('userPaymentMethods.edit', $userPaymentMethod->id) }}">Edit</a>
                <form method="POST" action="{{ route('userPaymentMethods.destroy', $userPaymentMethod->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
