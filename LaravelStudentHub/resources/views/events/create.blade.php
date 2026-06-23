<x-app-layout>
    <x-slot name="header">
        <h2>Dodaj wydarzenie</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('events.store') }}" class="bg-white p-6 rounded shadow">
            @csrf

            <label>Tytuł</label>
            <input name="title" class="border p-2 w-full mb-3" value="{{ old('title') }}">

            <label>Opis</label>
            <textarea name="description" class="border p-2 w-full mb-3">{{ old('description') }}</textarea>

            <label>Data rozpoczęcia</label>
            <input type="datetime-local" name="start_date" class="border p-2 w-full mb-3">

            <label>Data zakończenia</label>
            <input type="datetime-local" name="end_date" class="border p-2 w-full mb-3">

            <label>Miejsce</label>
            <input name="location" class="border p-2 w-full mb-3" value="{{ old('location') }}">

            <label>Limit miejsc</label>
            <input type="number" name="max_participants" class="border p-2 w-full mb-3">

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Zapisz</button>
        </form>

        @if ($errors->any())
            <div class="mt-4 text-red-600">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>