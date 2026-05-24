<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj zadanie</title>
</head>
<body>
    <h1>Dodaj zadanie</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <p>
            <label>Tytuł:</label><br>
            <input type="text" name="Title" value="{{ old('Title') }}">
        </p>

        <p>
            <label>Czy wykonane:</label><br>
            <select name="IsDone">
                <option value="0">Nie</option>
                <option value="1">Tak</option>
            </select>
        </p>

        <p>
            <label>Data rozpoczęcia:</label><br>
            <input type="datetime-local" name="StartDateTime" value="{{ old('StartDateTime') }}">
        </p>

        <p>
            <label>Opis:</label><br>
            <textarea name="Description">{{ old('Description') }}</textarea>
        </p>

        <p>
            <label>Deadline:</label><br>
            <input type="datetime-local" name="Deadline" value="{{ old('Deadline') }}">
        </p>

        <p>
            <label>Wydarzenie wewnętrzne:</label><br>
            <select name="InternalEventId">
                @foreach($internalEvents as $event)
                    <option value="{{ $event->Id }}">{{ $event->Title }}</option>
                @endforeach
            </select>
        </p>

        <p>
            <label>Notatki:</label><br>
            <textarea name="Notes">{{ old('Notes') }}</textarea>
        </p>

        <p>
            <label>Czy aktywne:</label><br>
            <select name="IsActive">
                <option value="1">Tak</option>
                <option value="0">Nie</option>
            </select>
        </p>

        <button type="submit">Zapisz</button>
    </form>

    <p>
        <a href="{{ route('tasks.index') }}">Powrót do listy</a>
    </p>
</body>
</html>
