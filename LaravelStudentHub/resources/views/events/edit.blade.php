<x-app-layout>
    <x-slot name="header">
        <h2>Edytuj wydarzenie</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('events.update', $event) }}" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <label>Tytuł</label>
            <input name="title" class="border p-2 w-full mb-3" value="{{ old('title', $event->title) }}">

            <label>Opis</label>
            <textarea name="description" class="border p-2 w-full mb-3">{{ old('description', $event->description) }}</textarea>

            <label>Data rozpoczęcia</label>
            <input type="datetime-local" name="start_date" class="border p-2 w-full mb-3"
                   value="{{ date('Y-m-d\TH:i', strtotime($event->start_date)) }}">

            <label>Data zakończenia</label>
            <input type="datetime-local" name="end_date" class="border p-2 w-full mb-3"
                   value="{{ $event->end_date ? date('Y-m-d\TH:i', strtotime($event->end_date)) : '' }}">

            <label>Miejsce</label>
            <input name="location" class="border p-2 w-full mb-3" value="{{ old('location', $event->location) }}">

            <label>Limit miejsc</label>
            <input type="number" name="max_participants" class="border p-2 w-full mb-3"
                   value="{{ old('max_participants', $event->max_participants) }}">

            <button class="bg-blue-600 text-white px-4 py-2 rounded">Zapisz zmiany</button>
        </form>

        <form method="POST" action="{{ route('events.destroy', $event) }}" class="mt-4">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Usuń wydarzenie
            </button>
        </form>
    </div>
</x-app-layout>