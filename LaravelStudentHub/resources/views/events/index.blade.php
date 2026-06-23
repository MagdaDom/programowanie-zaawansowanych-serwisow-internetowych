<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-3xl font-bold mb-6">Wydarzenia</h1>

        <form method="GET" action="{{ route('events.index') }}" class="mb-6">
            <input
                type="text"
                name="search"
                placeholder="Szukaj wydarzeń..."
                value="{{ request('search') }}"
                class="border p-2 rounded"
            >

            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">
                Szukaj
            </button>
        </form>

        @auth
            <a href="{{ route('events.create') }}" class="bg-primary text-white px-4 py-2 rounded">
                Dodaj wydarzenie
            </a>
        @endauth

        <h2 class="text-2xl font-bold mt-8 mb-4">Nadchodzące wydarzenia</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($upcomingEvents as $event)
                @include('events.partials.card', ['event' => $event])
            @empty
                <p>Brak nadchodzących wydarzeń.</p>
            @endforelse
        </div>

        <h2 class="text-2xl font-bold mt-10 mb-4">Wydarzenia historyczne</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($pastEvents as $event)
                @include('events.partials.card', ['event' => $event])
            @empty
                <p>Brak wydarzeń historycznych.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>