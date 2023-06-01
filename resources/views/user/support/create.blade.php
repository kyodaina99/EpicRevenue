@extends('shared.layout')

@section('body')
    <h1>Create Support Ticket</h1>

    <form action="{{ route('support.store') }}" method="POST">
        @csrf
        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="">Select a Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <div>
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" required>
        </div>

        <div>
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="4" required></textarea>
        </div>

        <button type="submit">Submit</button>
    </form>
@endsection
