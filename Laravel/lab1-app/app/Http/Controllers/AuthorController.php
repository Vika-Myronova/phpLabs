<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;


class AuthorController extends Controller
{

    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_year' => 'nullable|numeric',
        ]);

        Author::create($request->only(['name', 'birth_year']));

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function show(string $id)
    {
        $author = Author::findOrFail($id);
        return view('authors.show', compact('author'));
    }

    public function edit(string $id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_year' => 'nullable|numeric',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->only(['name', 'birth_year']));

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
