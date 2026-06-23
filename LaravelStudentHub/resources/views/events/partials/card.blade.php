<div class="bg-white rounded shadow p-6 text-center">
    <img
        src="{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('content/event-default.png') }}"
        alt="{{ $event->title }}"
        class="w-full h-40 object-cover rounded mb-4"
    >

    <h3 class="text-xl font-bold mb-3">{{ $event->title }}</h3>

    <p class="mb-3">
        {{ $event->short_description }}
    </p>

    <p>
        <strong>Data:</strong>
        {{ $event->event_date }}
    </p>

    @if($event->requires_registration)
        <p class="text-accent font-semibold mt-2">
            Wymaga zapisów
        </p>
    @endif

    <a href="{{ route('events.show', $event) }}" class="text-accent inline-block mt-3">
        Czytaj więcej...
    </a>

    @auth
        <div class="mt-3">
            <a href="{{ route('events.edit', $event) }}" class="text-primary font-semibold">
                Edytuj
            </a>
        </div>
    @endauth
</div>