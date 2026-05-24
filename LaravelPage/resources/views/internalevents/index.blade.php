<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Events - All</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Internal Events - All</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('internalevents.create') }}" class="btn btn-primary">Create new</a>
            <a href="{{ route('internalevents.index') }}" class="btn btn-outline-secondary">All</a>
        </div>
    </div>

    <div class="row g-3">
        @foreach($internalEvents as $event)
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->Title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $event->ShortDescription }}</h6>
                        <p class="card-text">{{ $event->ContentHTML }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('internalevents.edit', $event->Id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('internalevents.destroy', $event->Id) }}" method="POST">
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
