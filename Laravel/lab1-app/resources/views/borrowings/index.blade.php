@extends('layouts.app')

@section('content')
    <h1>Borrowings</h1>
    <a href="{{ route('borrowings.create') }}">Create New Borrowing</a>
    <form method="GET" action="{{ route('borrowings.index') }}" class="mb-4">
        <div class="row">
            <div class="col">
                <input type="date" name="borrow_date" class="form-control" placeholder="Borrow Date"
                       value="{{ request('borrow_date') }}">
            </div>
            <div class="col">
                <input type="date" name="return_date" class="form-control" placeholder="Return Date"
                       value="{{ request('return_date') }}">
            </div>
            <div class="col">
                <select name="book_id" class="form-control">
                    <option value="">All Books</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select name="reader_id" class="form-control">
                    <option value="">All Readers</option>
                    @foreach($readers as $reader)
                        <option value="{{ $reader->id }}" {{ request('reader_id') == $reader->id ? 'selected' : '' }}>
                            {{ $reader->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
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
@endsection
