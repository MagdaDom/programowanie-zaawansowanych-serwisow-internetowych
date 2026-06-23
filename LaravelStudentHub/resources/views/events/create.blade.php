<x-app-layout>
    <x-slot name="header">
        <h2>Dodaj wydarzenie</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf

            <label>Tytuł</label>
            <input name="title" class="border p-2 w-full mb-3" value="{{ old('title') }}" required>

            <label>Krótki opis na kartę</label>
            <textarea name="short_description" class="border p-2 w-full mb-3">{{ old('short_description') }}</textarea>

            <label>Pełna treść HTML wydarzenia</label>
            <textarea name="html_content" rows="8" class="border p-2 w-full mb-3">{{ old('html_content') }}</textarea>

            <label>Zdjęcie wydarzenia</label>
            <input type="file" name="image" accept="image/*" class="border p-2 w-full mb-3">
            <img id="imagePreview" class="mt-3 max-h-60 rounded hidden" alt="Podgląd zdjęcia">

            <label>Data wydarzenia</label>
            <input type="datetime-local" name="event_date" class="border p-2 w-full mb-3"
                   value="{{ old('event_date') }}" required>

            <label>Początek publikacji</label>
            <input type="datetime-local" name="publish_from" class="border p-2 w-full mb-3"
                   value="{{ old('publish_from') }}">

            <label>Koniec publikacji</label>
            <input type="datetime-local" name="publish_until" class="border p-2 w-full mb-3"
                   value="{{ old('publish_until') }}">

            <label>Cykliczność</label>
            <select name="recurrence" class="border p-2 w-full mb-3">
                <option value="none">Brak</option>
                <option value="weekly">Cotygodniowe</option>
                <option value="monthly">Comiesięczne</option>
                <option value="yearly">Coroczne</option>
            </select>

            <label class="flex items-center gap-2 mb-3">
                <input type="checkbox" name="requires_registration" value="1">
                Wydarzenie wymaga zapisów
            </label>

            <label>Limit miejsc</label>
            <input type="number" name="max_participants" class="border p-2 w-full mb-3"
                   value="{{ old('max_participants') }}">

            <button class="bg-primary text-white px-4 py-2 rounded">
                Zapisz
            </button>
        </form>

        <script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.querySelector('input[name="image"]');
    const preview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });

});
</script>

        @if ($errors->any())
            <div class="mt-4 text-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>