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
        <h1 class="mb-4">System CRUD</h1>
        <p class="lead">Wybierz moduł, który chcesz otworzyć.</p>

        <div class="d-flex gap-3 mt-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Przejdź do Tasks</a>
        </div>
    </div>
</body>
</html>
