@extends('layouts.app')

@section('content')
    <h1>Borrowings</h1>
    <a href="{{ route('borrowings.create') }}">Create New Borrowing</a>
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
