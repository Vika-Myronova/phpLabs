@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Are you sure you want to delete this borrowing record?</h1>

        <p><strong>Book:</strong> {{ $borrowing->book->title }}</p>
        <p><strong>Reader:</strong> {{ $borrowing->reader->fullName }}</p>

        <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, delete</button>
            <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
