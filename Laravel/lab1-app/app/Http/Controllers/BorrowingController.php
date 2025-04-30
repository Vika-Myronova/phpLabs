<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Reader;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::all();
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('borrowings.create', compact('books', 'readers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:book,id',
            'reader_id' => 'required|exists:reader,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        Borrowing::create([
            'book_id' => $request->book_id,
            'reader_id' => $request->reader_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
        ]);

        return redirect()->route('borrowings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = Borrowing::with(['book', 'reader'])->findOrFail($id);
        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('borrowings.edit', compact('borrowing', 'books', 'readers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'book_id' => 'required|exists:book,id',
            'reader_id' => 'required|exists:reader,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->book_id = $request->book_id;
        $borrowing->reader_id = $request->reader_id;
        $borrowing->borrow_date = $request->borrow_date;
        $borrowing->return_date = $request->return_date;
        $borrowing->save();

        return redirect()->route('borrowings.index')->with('success', 'Borrowing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index');
    }
}
