@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Are you sure you want to delete the book "{{ $book->title }}"?</h1>

        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, delete</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
