@extends('layouts.app')

@section('content')
    <h1>Edit Author</h1>

    <form action="{{ route('authors.update', $author->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name:</label>
        <input type="text" name="name" value="{{ $author->name }}" required>
        <br>
        <label>Birth Year:</label>
        <input type="number" name="birth_year" value="{{ $author->birth_year }}">
        <br>
        <button type="submit">Update</button>
    </form>
@endsection
