@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Authors</h1>
        <a href="{{ route('authors.create') }}" class="btn btn-primary mb-3">Add New Author</a>
        <form method="GET" action="{{ route('authors.index') }}" class="mb-3">
            <input type="text" name="name" value="{{ request('name') }}" placeholder="Author Name">
            <input type="text" name="birth_year" value="{{ request('birth_year') }}" placeholder="Birth Year">

            <div class="col">
                <select name="itemsPerPage" class="form-control" onchange="this.form.submit()">
                    <option value="2" {{ request('itemsPerPage') == '2' ? 'selected' : '' }}>2</option>
                    <option value="5" {{ request('itemsPerPage') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('itemsPerPage') == '10' ? 'selected' : '' }}>10</option>
                </select>
            </div>

            <button type="submit">Filter</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Birth year</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>{{ $author->birth_year }}</td>
                    <td>
                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $authors->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
@endsection
