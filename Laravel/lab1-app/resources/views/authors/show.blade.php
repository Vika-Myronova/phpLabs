@extends('layouts.app')

@section('content')
    <h1>Author Details</h1>

    <p><strong>Name:</strong> {{ $author->name }}</p>
    <p><strong>Birth Year:</strong> {{ $author->birth_year ?? 'N/A' }}</p>

    <a href="{{ route('authors.index') }}">Back to list</a>
@endsection
