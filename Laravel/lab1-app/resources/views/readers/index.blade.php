@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Readers</h1>
        <a href="{{ route('readers.create') }}" class="btn btn-primary mb-3">Add New Reader</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($readers as $reader)
                <tr>
                    <td>{{ $reader->full_name }}</td>
                    <td>{{ $reader->email }}</td>
                    <td>
                        <a href="{{ route('readers.show', $reader->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('readers.edit', $reader->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('readers.destroy', $reader->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
