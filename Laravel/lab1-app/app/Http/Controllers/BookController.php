<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->only(['title', 'published_year', 'isbn', 'author_id']);
        $itemsPerPage = $request->get('itemsPerPage', 2);

        $books = Book::paginateWithFilters($filters, $itemsPerPage);
        $authors = Author::all();

        return view('books.index', compact('books', 'authors'));
    }


    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'published_year' => 'nullable|integer',
            'author_id' => 'required|exists:author,id',
            'categories' => 'nullable|array',
        ]);

        $book = Book::create($request->all());
        $book->categories()->sync($request->categories);

        return redirect()->route('books.index');
    }


    public function show(string $id)
    {
        $book = Book::with(['author', 'categories', 'borrowings'])->findOrFail($id);
        return view('books.show', compact('book'));
    }


    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'published_year' => 'nullable|integer',
            'author_id' => 'required|exists:author,id',
            'categories' => 'nullable|array',
        ]);

        $book->update($request->all());
        $book->categories()->sync($request->categories);

        return redirect()->route('books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index');
    }
}
