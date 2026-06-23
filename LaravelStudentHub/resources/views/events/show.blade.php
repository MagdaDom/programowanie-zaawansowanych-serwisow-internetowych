<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">{{ $event->title }}</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <img
                src="{{ $event->image_path ? asset($event->image_path) : asset('content/event-default.png') }}"
                alt="{{ $event->title }}"
                class="w-full max-h-96 object-cover rounded mb-6"
            >

            <p><strong>Data wydarzenia:</strong> {{ $event->event_date }}</p>

            @if($event->recurrence !== 'none')
                <p><strong>Cykliczność:</strong>
                    @switch($event->recurrence)
                        @case('weekly') cotygodniowe @break
                        @case('monthly') comiesięczne @break
                        @case('yearly') coroczne @break
                    @endswitch
                </p>
            @endif

            <div class="mt-6 prose max-w-none">
                {!! $event->html_content !!}
            </div>

            @if($event->requires_registration)
                <div class="mt-6">
                    <p><strong>Limit miejsc:</strong> {{ $event->max_participants }}</p>
                    <p><strong>Zapisanych:</strong> {{ $event->participants()->count() }}</p>

                    @auth
                        @if($event->event_date >= now())
                            <form method="POST" action="{{ route('events.register', $event) }}" class="mt-4">
                                @csrf
                                <button class="bg-primary text-white px-4 py-2 rounded">
                                    Zapisz się na wydarzenie
                                </button>
                            </form>
                        @endif
                    @endauth

                    @guest
                        <p class="mt-4">
                            <a href="{{ route('login') }}" class="text-primary font-semibold">
                                Zaloguj się
                            </a>,
                            aby zapisać się na wydarzenie.
                        </p>
                    @endguest
                </div>
            @endif

            @auth
                <a href="{{ route('events.edit', $event) }}" class="inline-block mt-6 text-primary font-semibold">
                    Edytuj wydarzenie
                </a>
            @endauth

            @if(session('success'))
                <p class="text-success mt-4">{{ session('success') }}</p>
            @endif

            @if(session('error'))
                <p class="text-danger mt-4">{{ session('error') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>