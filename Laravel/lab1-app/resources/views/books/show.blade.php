@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>
        <p><strong>Author:</strong> {{ $book->author->name }}</p>
        <p><strong>Published Year:</strong> {{ $book->publishedYear }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>

        <h3>Categories</h3>
        <ul>
            @foreach($book->categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>

        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>
    </div>
@endsection
