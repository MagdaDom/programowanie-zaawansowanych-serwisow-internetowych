<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaravelPage</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">CRUD w Laravel (PHP obiektowy)</h1>
        <p class="lead">Wybierz moduł, który chcesz otworzyć.</p>

        <div class="d-flex gap-3 mt-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Przejdź do Tasks</a>
            <a href="{{ route('internalevents.index') }}" class="btn btn-outline-primary">Przejdź do InternalEvents</a>
        </div>
    </div>
</body>
</html>
