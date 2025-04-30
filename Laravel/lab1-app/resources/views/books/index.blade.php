@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>
        <form method="GET" action="{{ route('books.index') }}" class="mb-3">
            <input type="text" name="title" value="{{ request('title') }}" placeholder="Title">
            <input type="text" name="published_year" value="{{ request('published_year') }}" placeholder="Published Year">
            <input type="text" name="isbn" value="{{ request('isbn') }}" placeholder="ISBN">

            <select name="author_id">
                <option value="">-- Select Author --</option>
                @foreach($books as $book)
                    <option value="{{ $book->author->id }}" {{ request('author_id') == $book->author->id ? 'selected' : '' }}>
                        {{ $book->author->name }}
                    </option>
                @endforeach
            </select>
            <div class="col">
                <select name="itemsPerPage" class="form-control" onchange="this.form.submit()">
                    <option value="2" {{ request('itemsPerPage') == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ request('itemsPerPage') == '3' ? 'selected' : '' }}>3</option>
                    <option value="10" {{ request('itemsPerPage') == '10' ? 'selected' : '' }}>10</option>
                </select>
            </div>
            <button type="submit">Filter</button>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
                <th>ISBN</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->published_year }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>
                        @foreach($book->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
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
    <div class="d-flex justify-content-center">
        {{ $books->links('pagination::simple-bootstrap-4') }}
    </div>
@endsection
