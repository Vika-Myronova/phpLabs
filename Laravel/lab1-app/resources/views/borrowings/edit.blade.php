@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Borrowing</h1>
        <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="book_id" class="form-label">Book</label>
                <select class="form-control" id="book_id" name="book_id" required>
                    <option value="">Select Book</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="reader_id" class="form-label">Reader</label>
                <select class="form-control" id="reader_id" name="reader_id" required>
                    <option value="">Select Reader</option>
                    @foreach($readers as $reader)
                        <option value="{{ $reader->id }}" {{ $borrowing->reader_id == $reader->id ? 'selected' : '' }}>
                            {{ $reader->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('reader_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="borrow_date" class="form-label">Borrow Date</label>
                <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', optional($borrowing->borrow_date)->format('Y-m-d')) }}" required>
                @error('borrow_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date (optional)</label>
                <input type="date" class="form-control" id="return_date" name="return_date" value="{{ old('return_date', optional($borrowing->return_date)->format('Y-m-d')) }}">
                @error('returnDate')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Borrowing</button>
        </form>
    </div>
@endsection
