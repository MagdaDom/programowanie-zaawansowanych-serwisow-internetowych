<x-app-layout>
    <x-slot name="header">
        <h2>Edytuj wydarzenie</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('events.update', $event) }}" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <label>Tytuł</label>
            <input name="title" class="border p-2 w-full mb-3"
                   value="{{ old('title', $event->title) }}">

            <label>Krótki opis na kartę</label>
            <textarea name="short_description" class="border p-2 w-full mb-3">{{ old('short_description', $event->short_description) }}</textarea>

            <label>Pełna treść HTML wydarzenia</label>
            <textarea name="html_content" rows="8" class="border p-2 w-full mb-3">{{ old('html_content', $event->html_content) }}</textarea>

            <label>Ścieżka do obrazka</label>
            <input name="image_path" class="border p-2 w-full mb-3"
                   value="{{ old('image_path', $event->image_path) }}">

            <label>Data wydarzenia</label>
            <input type="datetime-local" name="event_date" class="border p-2 w-full mb-3"
                   value="{{ $event->event_date ? $event->event_date->format('Y-m-d\TH:i') : '' }}">

            <label>Początek publikacji</label>
            <input type="datetime-local" name="publish_from" class="border p-2 w-full mb-3"
                   value="{{ $event->publish_from ? $event->publish_from->format('Y-m-d\TH:i') : '' }}">

            <label>Koniec publikacji</label>
            <input type="datetime-local" name="publish_until" class="border p-2 w-full mb-3"
                   value="{{ $event->publish_until ? $event->publish_until->format('Y-m-d\TH:i') : '' }}">

            <label>Cykliczność</label>
            <select name="recurrence" class="border p-2 w-full mb-3">
                <option value="none" {{ $event->recurrence === 'none' ? 'selected' : '' }}>Brak</option>
                <option value="weekly" {{ $event->recurrence === 'weekly' ? 'selected' : '' }}>Cotygodniowe</option>
                <option value="monthly" {{ $event->recurrence === 'monthly' ? 'selected' : '' }}>Comiesięczne</option>
                <option value="yearly" {{ $event->recurrence === 'yearly' ? 'selected' : '' }}>Coroczne</option>
            </select>

            <label class="flex items-center gap-2 mb-3">
                <input type="checkbox"
                       name="requires_registration"
                       value="1"
                       {{ $event->requires_registration ? 'checked' : '' }}>
                Wydarzenie wymaga zapisów
            </label>

            <label>Limit miejsc</label>
            <input type="number"
                   name="max_participants"
                   class="border p-2 w-full mb-3"
                   value="{{ old('max_participants', $event->max_participants) }}">

            <button class="bg-primary text-white px-4 py-2 rounded">
                Zapisz zmiany
            </button>
        </form>

        <form method="POST" action="{{ route('events.destroy', $event) }}" class="mt-4">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Usuń wydarzenie
            </button>
        </form>

        @if ($errors->any())
            <div class="mt-4 text-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>