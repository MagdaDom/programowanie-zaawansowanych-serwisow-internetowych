<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Create</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tasks - Create</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('home.index') }}" class="btn btn-outline-dark">Strona główna</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">All</a>
        </div>
    </div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="Title" class="form-control" value="{{ old('Title') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Is Done</label>
            <select name="IsDone" class="form-select">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date Time</label>
            <input type="datetime-local" name="StartDateTime" class="form-control" value="{{ old('StartDateTime') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="Description" class="form-control" rows="4">{{ old('Description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="datetime-local" name="Deadline" class="form-control" value="{{ old('Deadline') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Internal Event</label>
            <select name="InternalEventId" class="form-select">
                @foreach($internalEvents as $event)
                    <option value="{{ $event->Id }}">{{ $event->Title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="Notes" class="form-control" rows="3">{{ old('Notes') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
