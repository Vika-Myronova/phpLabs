@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

        <form method="GET" action="{{ route('categories.index') }}" class="mb-3">
            <input type="text" name="name" value="{{ request('name') }}" placeholder="Category Name">

            <div class="col">
                <select name="itemsPerPage" class="form-control" onchange="this.form.submit()">
                    <option value="2" {{ request('itemsPerPage') == '2' ? 'selected' : '' }}>2</option>
                    <option value="5" {{ request('itemsPerPage') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('itemsPerPage') == '10' ? 'selected' : '' }}>10</option>
                </select>
            </div>

            <button type="submit">Filter</button>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
            {{ $categories->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
@endsection
