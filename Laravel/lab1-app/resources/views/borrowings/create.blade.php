@extends('layouts.app')

@section('content')
    <h1>Create Borrowing</h1>
    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        <label for="book_id">Book</label>
        <select name="book_id" id="book_id">
            @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
            @endforeach
        </select>
        <br>

        <label for="reader_id">Reader</label>
        <select name="reader_id" id="reader_id">
            @foreach($readers as $reader)
                <option value="{{ $reader->id }}">{{ $reader->full_name }}</option>
            @endforeach
        </select>
        <br>

        <label for="borrow_date">Borrow Date</label>
        <input type="date" name="borrow_date" id="borrow_date">
        <br>

        <label for="return_date">Return Date</label>
        <input type="date" name="return_date" id="return_date">
        <br>

        <button type="submit">Submit</button>
    </form>
@endsection
