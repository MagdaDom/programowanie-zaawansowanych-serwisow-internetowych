<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - All</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tasks - All</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('home.index') }}" class="btn btn-outline-dark">Strona główna</a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create new</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">All</a>
        </div>
    </div>

    <div class="row g-3">
        @foreach($tasks as $task)
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->Title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ $task->internalEvent->Title ?? 'Brak wydarzenia' }}
                        </h6>

                        <p class="card-text mb-2">{{ $task->Description }}</p>

                        <p class="mb-1"><strong>Start:</strong> {{ $task->StartDateTime }}</p>
                        <p class="mb-1"><strong>Deadline:</strong> {{ $task->Deadline }}</p>
                        <p class="mb-1"><strong>Aktywne:</strong> {{ $task->IsActive ? 'Tak' : 'Nie' }}</p>
                        <p class="mb-3"><strong>Wykonane:</strong> {{ $task->IsDone ? 'Tak' : 'Nie' }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('tasks.edit', $task->Id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('tasks.destroy', $task->Id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
