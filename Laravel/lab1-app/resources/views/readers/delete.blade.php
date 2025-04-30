@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Are you sure you want to delete {{ $reader->fullName }}?</h1>

        <form action="{{ route('readers.destroy', $reader->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, delete</button>
            <a href="{{ route('readers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
