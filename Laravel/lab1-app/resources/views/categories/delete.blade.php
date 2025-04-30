@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Are you sure you want to delete the category "{{ $category->name }}"?</h1>

        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, delete it</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
