@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Borrowing Details</h1>

        <p><strong>Book:</strong> {{ $borrowing->book->title }}</p>
        <p><strong>Reader:</strong> {{ $borrowing->reader->full_name }}</p>
        <p><strong>Borrow Date:</strong> {{ $borrowing->borrow_date->format('Y-m-d') }}</p>

        @if($borrowing->return_date)
            <p><strong>Return Date:</strong> {{ $borrowing->return_date->format('Y-m-d') }}</p>
        @else
            <p><strong>Return Date:</strong> Not returned yet</p>
        @endif

        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Back to Borrowings</a>
    </div>
@endsection
