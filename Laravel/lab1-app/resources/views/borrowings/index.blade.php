@extends('layouts.app')

@section('content')
    <h1>Borrowings</h1>
    <a href="{{ route('borrowings.create') }}">Create New Borrowing</a>
    <form method="GET" action="{{ route('borrowings.index') }}" class="mb-3">
        <input type="date" name="borrow_date" value="{{ request('borrow_date') }}" placeholder="Borrow Date">
        <input type="date" name="return_date" value="{{ request('return_date') }}" placeholder="Return Date">

        <select name="book_id">
            <option value="">-- Select Book --</option>
            @foreach($books as $book)
                <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
            @endforeach
        </select>

        <select name="reader_id">
            <option value="">-- Select Reader --</option>
            @foreach($readers as $reader)
                <option value="{{ $reader->id }}" {{ request('reader_id') == $reader->id ? 'selected' : '' }}>
                    {{ $reader->name }}
                </option>
            @endforeach
        </select>

        <div class="col">
            <select name="itemsPerPage" class="form-control" onchange="this.form.submit()">
                <option value="2" {{ request('itemsPerPage') == '2' ? 'selected' : '' }}>2</option>
                <option value="5" {{ request('itemsPerPage') == '5' ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('itemsPerPage') == '10' ? 'selected' : '' }}>10</option>
            </select>
        </div>

        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Book</th>
            <th>Reader</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($borrowings as $borrowing)
            <tr>
                <td>{{ $borrowing->book->title }}</td>
                <td>{{ $borrowing->reader->fullName }}</td>
                <td>{{ $borrowing->borrow_date }}</td>
                <td>{{ $borrowing->return_date }}</td>
                <td>
                    <a href="{{ route('borrowings.show', $borrowing) }}">View</a>
                    <a href="{{ route('borrowings.edit', $borrowing) }}">Edit</a>
                    <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $borrowings->links('pagination::simple-bootstrap-4') }}
    </div>
@endsection
