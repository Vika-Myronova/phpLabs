@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $category->name }}</h1>
        <h3>Books in this category</h3>
        <ul>
            @foreach($category->books as $book)
                <li>{{ $book->title }} ({{ $book->publishedYear }})</li>
            @endforeach
        </ul>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
    </div>
@endsection
