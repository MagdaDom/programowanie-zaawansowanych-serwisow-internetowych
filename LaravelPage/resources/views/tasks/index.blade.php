<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista zadań</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <h1>Lista zadań</h1>

    <p>
        <a href="{{ route('tasks.create') }}">Dodaj nowe zadanie</a>
    </p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Data rozpoczęcia</th>
                <th>Deadline</th>
                <th>Wydarzenie wewnętrzne</th>
                <th>Aktywne</th>
                <th>Wykonane</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->Id }}</td>
                <td>{{ $task->Title }}</td>
                <td>{{ $task->Description }}</td>
                <td>{{ $task->StartDateTime }}</td>
                <td>{{ $task->Deadline }}</td>
                <td>{{ $task->internalEvent->Title ?? 'Brak' }}</td>
                <td>{{ $task->IsActive ? 'Tak' : 'Nie' }}</td>
                <td>{{ $task->IsDone ? 'Tak' : 'Nie' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->Id) }}">Edytuj</a>

                    <form action="{{ route('tasks.destroy', $task->Id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
