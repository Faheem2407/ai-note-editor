@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Note</h2>

    <form action="{{ route('notes.update', $note) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $note->title }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Note Content</label>
            <textarea name="content" class="form-control" id="content" rows="6" required>{{ $note->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Note</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
