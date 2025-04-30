@extends('layouts.app')

@section('content')
    <h1>Create Author</h1>

    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>
        <br>
        <label>Birth Year:</label>
        <input type="number" name="birth_year">
        <br>
        <button type="submit">Save</button>
    </form>
@endsection
