<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->middleware('role:ROLE_ADMIN,ROLE_MANAGER')->only(['store', 'create', 'edit', 'update', 'destroy']);
        $this->middleware('role:ROLE_CLIENT')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $itemsPerPage = $request->get('itemsPerPage', 2);
        $categories = Category::filter($filters)->paginate($itemsPerPage);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        $category = Category::with('books')->findOrFail($id);
        return view('categories.show', compact('category'));
    }


    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
