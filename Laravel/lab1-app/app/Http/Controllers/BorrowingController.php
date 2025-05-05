<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Reader;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->middleware('role:ROLE_ADMIN,ROLE_MANAGER')->only(['store', 'create', 'edit', 'update', 'destroy']);
        $this->middleware('role:ROLE_CLIENT')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['borrow_date', 'return_date', 'book_id', 'reader_id']);
        $itemsPerPage = $request->get('itemsPerPage', 10);
        $borrowings = Borrowing::filter($filters)->paginate($itemsPerPage);

        $books = Book::select('id', 'title')->get();
        $readers = Reader::select('id', 'full_name')->get();

        return view('borrowings.index', compact('borrowings', 'books', 'readers'));
    }


    public function create()
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('borrowings.create', compact('books', 'readers'));
    }


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


    public function show(string $id)
    {
        $borrowing = Borrowing::with(['book', 'reader'])->findOrFail($id);
        return view('borrowings.show', compact('borrowing'));
    }

    public function edit(Borrowing $borrowing)
    {
        $books = Book::all();
        $readers = Reader::all();
        return view('borrowings.edit', compact('borrowing', 'books', 'readers'));
    }

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

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('borrowings.index');
    }
}
