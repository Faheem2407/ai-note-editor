<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Notes Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <header class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ auth()->user()->avatar }}" alt="Avatar" width="60" height="60" class="rounded-circle border" />
                <div>
                    <h4 class="mb-0">Welcome, {{ auth()->user()->name }} 👋</h4>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </header>

        <div class="text-center">
            <a href="{{ route('notes.index') }}" class="btn btn-success btn-lg px-4">
                📝 Your Notes
            </a>
        </div>
    </div>
</body>
</html>
