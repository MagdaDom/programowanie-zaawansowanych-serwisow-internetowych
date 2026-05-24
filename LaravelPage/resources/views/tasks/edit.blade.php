<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Edit</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tasks - Edit</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('home.index') }}" class="btn btn-outline-dark">Strona główna</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">All</a>
        </div>
    </div>

    <form method="POST" action="{{ route('tasks.update', $task->Id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="Title" class="form-control" value="{{ old('Title', $task->Title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Is Done</label>
            <select name="IsDone" class="form-select">
                <option value="0" {{ old('IsDone', $task->IsDone) ? '' : 'selected' }}>No</option>
                <option value="1" {{ old('IsDone', $task->IsDone) ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date Time</label>
            <input type="datetime-local" name="StartDateTime" class="form-control" value="{{ old('StartDateTime', optional($task->StartDateTime)->format('Y-m-d\\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="Description" class="form-control" rows="4">{{ old('Description', $task->Description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="datetime-local" name="Deadline" class="form-control" value="{{ old('Deadline', optional($task->Deadline)->format('Y-m-d\\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Internal Event</label>
            <select name="InternalEventId" class="form-select">
                @foreach($internalEvents as $event)
                    <option value="{{ $event->Id }}" {{ old('InternalEventId', $task->InternalEventId) == $event->Id ? 'selected' : '' }}>
                        {{ $event->Title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="Notes" class="form-control" rows="3">{{ old('Notes', $task->Notes) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Active</label>
            <select name="IsActive" class="form-select">
                <option value="1" {{ old('IsActive', $task->IsActive) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('IsActive', $task->IsActive) ? '' : 'selected' }}>No</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
