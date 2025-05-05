<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->middleware('role:ROLE_ADMIN,ROLE_MANAGER')->only(['store', 'create', 'edit', 'update', 'destroy']);
        $this->middleware('role:ROLE_CLIENT')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['full_name', 'email']);
        $itemsPerPage = $request->get('itemsPerPage', 2);
        $readers = Reader::filter($filters)->paginate($itemsPerPage);

        return view('readers.index', compact('readers'));
    }


    public function create()
    {
        return view('readers.create');
    }


    public function store(Request $request)
    {
        $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:reader,email',
    ]);
        Reader::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
        ]);


        return redirect()->route('readers.index');
    }


    public function show(string $id)
    {
        $reader = Reader::findOrFail($id);
        return view('readers.show', compact('reader'));
    }

    public function edit(string $id)
    {
        $reader = Reader::findOrFail($id);
        return view('readers.edit', compact('reader'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:reader,email,' . $id,
        ]);

        $reader = Reader::findOrFail($id);
        $reader->full_name = $request->full_name;
        $reader->email = $request->email;
        $reader->save();

        return redirect()->route('readers.index')->with('success', 'Reader updated successfully');
    }

    public function destroy(string $id)
    {
        $reader = Reader::findOrFail($id);
        $reader->delete();

        return redirect()->route('readers.index')->with('success', 'Reader deleted successfully');
    }
}
