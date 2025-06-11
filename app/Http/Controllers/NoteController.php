<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
	{
		$search = $request->input('search');

		$notesQuery = Auth::user()->notes()->latest();

		if ($search) {
			$notesQuery->where(function($query) use ($search) {
				$query->where('title', 'like', "%{$search}%")
					  ->orWhere('content', 'like', "%{$search}%");
			});
		}

		$notes = $notesQuery->paginate(10)->withQueryString();

		return view('notes.index', compact('notes', 'search'));
	}

    public function create()
    {
        return view('notes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Auth::user()->notes()->create($request->only('title', 'content'));

        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }


    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $note->update($request->only('title', 'content'));

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}
