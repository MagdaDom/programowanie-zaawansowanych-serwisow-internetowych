<x-app-layout>
    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">
            Wydarzenia
        </h1>

        <form method="GET" action="{{ route('events.index') }}">
            <input
                type="text"
                name="search"
                placeholder="Szukaj wydarzeń..."
                value="{{ request('search') }}"
                class="border p-2 rounded"
            >

            <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded">
                Szukaj
            </button>
        </form>

        <br>

        @auth
            <a href="{{ route('events.create') }}"
               class="bg-green-500 text-white px-3 py-2 rounded">
                Dodaj wydarzenie
            </a>
        @endauth

        <hr class="my-4">

        @foreach($events as $event)
            <div class="border p-4 mb-3 rounded">

                <h2 class="text-xl font-bold">
                    {{ $event->title }}
                </h2>

                <p>{{ $event->description }}</p>

                <p>
                    <strong>Miejsce:</strong>
                    {{ $event->location }}
                </p>

                <p>
                    <strong>Data:</strong>
                    {{ $event->start_date }}
                </p>

                <a href="{{ route('events.show', $event) }}">
                    Szczegóły
                </a>

            </div>
        @endforeach

        {{ $events->links() }}

    </div>
</x-app-layout>