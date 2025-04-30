@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $reader->fullName }}</h1>
        <p>Email: {{ $reader->email }}</p>

        <h3>Borrowings</h3>
        <ul>
            @foreach($reader->borrowings as $borrowing)
                <li>{{ $borrowing->book->title }} ({{ $borrowing->borrowDate->format('Y-m-d') }})</li>
            @endforeach
        </ul>

        <a href="{{ route('readers.index') }}" class="btn btn-secondary">Back to Readers</a>
    </div>
@endsection
