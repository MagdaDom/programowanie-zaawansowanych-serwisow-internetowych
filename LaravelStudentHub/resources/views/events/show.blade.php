<x-app-layout>
    <x-slot name="header">
        <h2>{{ $event->title }}</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <p>{{ $event->description }}</p>

            <p><strong>Miejsce:</strong> {{ $event->location }}</p>
            <p><strong>Start:</strong> {{ $event->start_date }}</p>
            <p><strong>Koniec:</strong> {{ $event->end_date }}</p>
            <p><strong>Limit miejsc:</strong> {{ $event->max_participants ?? 'Bez limitu' }}</p>
            <p><strong>Zapisanych:</strong> {{ $event->participants()->count() }}</p>

            @auth
                <form method="POST" action="{{ route('events.register', $event) }}" class="mt-4">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Zapisz się na wydarzenie
                    </button>
                </form>

                <a href="{{ route('events.edit', $event) }}" class="inline-block mt-4 text-blue-600">
                    Edytuj wydarzenie
                </a>
            @endauth

            @if(session('success'))
                <p class="text-green-600 mt-4">{{ session('success') }}</p>
            @endif

            @if(session('error'))
                <p class="text-red-600 mt-4">{{ session('error') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>