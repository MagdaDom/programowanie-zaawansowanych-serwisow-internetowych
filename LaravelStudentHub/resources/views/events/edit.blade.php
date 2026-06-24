<x-app-layout>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <h1 class="text-primary text-3xl font-bold mb-6">Edytuj wydarzenie</h1>

            <div class="flex gap-4 mb-4">
                <div>
                    <label>Data wydarzenia</label>
                    <input type="datetime-local"
                        name="event_date"
                        class="border p-2 w-full"
                        value="{{ $event->event_date ? $event->event_date->format('Y-m-d\TH:i') : '' }}">
                </div>

                <div>
                    <label>Początek publikacji</label>
                    <input type="datetime-local"
                        name="publish_from"
                        class="border p-2 w-full"
                        value="{{ $event->publish_from ? $event->publish_from->format('Y-m-d\TH:i') : '' }}">
                </div>

                <div>
                    <label>Koniec publikacji</label>
                    <input type="datetime-local"
                        name="publish_until"
                        class="border p-2 w-full"
                        value="{{ $event->publish_until ? $event->publish_until->format('Y-m-d\TH:i') : '' }}">
                </div>
            </div>

            <div class="flex gap-2 mb-2 justify-between">
                <div class="w-full">
                    <label>Tytuł</label>
                    <input name="title" class="border p-2 w-full mb-3"
                        value="{{ old('title', $event->title) }}">
                </div>

                <div>
                    <label>Cykliczność</label>
                    <select name="recurrence" class="border p-2 w-full mb-3">
                        <option value="none" {{ $event->recurrence === 'none' ? 'selected' : '' }}>Brak</option>
                        <option value="weekly" {{ $event->recurrence === 'weekly' ? 'selected' : '' }}>Cotygodniowe</option>
                        <option value="monthly" {{ $event->recurrence === 'monthly' ? 'selected' : '' }}>Comiesięczne</option>
                        <option value="yearly" {{ $event->recurrence === 'yearly' ? 'selected' : '' }}>Coroczne</option>
                    </select>
                </div>
            </div>

            <label>Krótki opis na kartę</label>
            <textarea name="short_description" class="border p-2 w-full mb-3">{{ old('short_description', $event->short_description) }}</textarea>

            <label>Pełna treść HTML wydarzenia</label>
            <textarea name="html_content" rows="8" class="border p-2 w-full mb-3">{{ old('html_content', $event->html_content) }}</textarea>

            @if($event->image_path)
                <label>Aktualne zdjęcie</label>
                <img src="{{ asset('storage/' . $event->image_path) }}"
                    class="max-h-60 rounded mb-3"
                    alt="{{ $event->title }}">
            @endif

            <img id="imagePreview" class="mt-3 max-h-60 rounded hidden" alt="Podgląd zdjęcia">      

            <div class="flex gap-4 mb-4">
                <div>
                    <label>Zmień zdjęcie wydarzenia</label>
                    <input type="file" name="image" accept="image/*" class="border p-2 w-full mb-3">
                </div>

                <div id="maxParticipantsContainer">
                    <label>Limit miejsc</label>
                    <input type="number"
                        name="max_participants"
                        class="border p-2 w-full mb-3"
                        value="{{ old('max_participants', $event->max_participants) }}">
                </div>
            </div>      

            <div class="flex gap-4 mb-4 justify-between">
                <div>   
                    <label class="flex items-center gap-2 mb-3">
                        <input type="checkbox"
                            id="requires_registration"
                            name="requires_registration"
                            value="0"
                            {{ $event->requires_registration ? 'checked' : '' }}>
                        Wydarzenie wymaga zapisów
                    </label>
                </div>

                <div class="ml-auto">
                    <button class="bg-primary text-white px-4 py-2 rounded">
                        <i class="bi bi-floppy-fill mr-2"></i>Zapisz zmiany
                    </button>
                </div>
            </div> 
            
        </form>

        <div class="mt-4 py-4 flex justify-between items-center">
            <div class="flex gap-2">
                <a href="{{ route('events.index') }}"
                class="bg-accent text-white px-4 py-2 rounded">
                    ← Powrót do wydarzeń
                </a>

                <a href="{{ route('home') }}"
                class="bg-primary text-white px-4 py-2 rounded">
                    ← Strona główna
                </a>
            </div>

            <form method="POST" action="{{ route('events.destroy', $event) }}" class="ml-auto">
                @csrf
                @method('DELETE')

                <button class="bg-red-600 text-white px-4 py-2 rounded inline-flex items-center gap-2">
                    <i class="bi bi-trash-fill"></i>Usuń wydarzenie
                </button>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const checkbox = document.getElementById('requires_registration');
                const container = document.getElementById('maxParticipantsContainer');
                const input = document.querySelector('input[name="max_participants"]');

                function toggleMaxParticipants() {

                    if (checkbox.checked) {
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                        input.value = '';
                    }
                }

                toggleMaxParticipants();

                checkbox.addEventListener('change', toggleMaxParticipants);

            });
        </script>

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