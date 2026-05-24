<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj zadanie</title>
</head>
<body>
    <h1>Edytuj zadanie</h1>

    <form method="POST" action="{{ route('tasks.update', $task->Id) }}">
        @csrf
        @method('PUT')

        <p>
            <label>Tytuł:</label><br>
            <input type="text" name="Title" value="{{ old('Title', $task->Title) }}">
        </p>

        <p>
            <label>Czy wykonane:</label><br>
            <select name="IsDone">
                <option value="0" {{ old('IsDone', $task->IsDone) ? '' : 'selected' }}>Nie</option>
                <option value="1" {{ old('IsDone', $task->IsDone) ? 'selected' : '' }}>Tak</option>
            </select>
        </p>

        <p>
            <label>Data rozpoczęcia:</label><br>
            <input type="datetime-local" name="StartDateTime" value="{{ old('StartDateTime', optional($task->StartDateTime)->format('Y-m-d\\TH:i')) }}">
        </p>

        <p>
            <label>Opis:</label><br>
            <textarea name="Description">{{ old('Description', $task->Description) }}</textarea>
        </p>

        <p>
            <label>Deadline:</label><br>
            <input type="datetime-local" name="Deadline" value="{{ old('Deadline', optional($task->Deadline)->format('Y-m-d\\TH:i')) }}">
        </p>

        <p>
            <label>Wydarzenie wewnętrzne:</label><br>
            <select name="InternalEventId">
                @foreach($internalEvents as $event)
                    <option value="{{ $event->Id }}" {{ old('InternalEventId', $task->InternalEventId) == $event->Id ? 'selected' : '' }}>
                        {{ $event->Title }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Notatki:</label><br>
            <textarea name="Notes">{{ old('Notes', $task->Notes) }}</textarea>
        </p>

        <p>
            <label>Czy aktywne:</label><br>
            <select name="IsActive">
                <option value="1" {{ old('IsActive', $task->IsActive) ? 'selected' : '' }}>Tak</option>
                <option value="0" {{ old('IsActive', $task->IsActive) ? '' : 'selected' }}>Nie</option>
            </select>
        </p>

        <button type="submit">Zapisz zmiany</button>
    </form>

    <p>
        <a href="{{ route('tasks.index') }}">Powrót do listy</a>
    </p>
</body>
</html>
