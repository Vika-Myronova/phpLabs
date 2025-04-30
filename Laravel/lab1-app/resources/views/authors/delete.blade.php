@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Are you sure you want to delete the author "{{ $author->name }}"?</h1>

        <form action="{{ route('authors.destroy', $author->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, delete</button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
