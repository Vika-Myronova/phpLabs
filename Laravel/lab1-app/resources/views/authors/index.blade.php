@extends('layouts.app')

@section('content')
    <h1>Authors</h1>
    <a href="{{ route('authors.create') }}">Create New Author</a>

    <ul>
        @foreach ($authors as $author)
            <li>
                {{ $author->name }} ({{ $author->birth_year ?? 'N/A' }})
                <a href="{{ route('authors.show', $author->id) }}">View</a> |
                <a href="{{ route('authors.edit', $author->id) }}">Edit</a> |
                <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

