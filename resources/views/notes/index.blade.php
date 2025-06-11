@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My Notes</h2>
        <a href="{{ route('notes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Create New Note
        </a>
    </div>

    <form method="GET" action="{{ route('notes.index') }}" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search notes..." 
                value="{{ request('search') }}"
                autocomplete="off"
            />
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>

    @if($notes->count())
        <div class="list-group">
            @foreach ($notes as $note)
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3 flex-grow-1">
                        <h5 class="mb-1">{{ $note->title }}</h5>
                        <p class="mb-1 text-muted">{{ \Illuminate\Support\Str::limit($note->content, 100) }}</p>
                        <small class="text-muted">Created: {{ $note->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    <div class="d-flex flex-column gap-2 text-nowrap">
                        <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this note?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $notes->withQueryString()->links() }}
        </div>
    @else
        <div class="alert alert-info">No notes found.</div>
    @endif
</div>
@endsection
