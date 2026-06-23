@if($event->requires_registration)
    @php
        $participantsCount = $event->participants()->count();
        $freePlaces = $event->max_participants ? $event->max_participants - $participantsCount : null;
        $userAlreadyRegistered = auth()->check()
            ? $event->participants()->where('user_id', auth()->id())->exists()
            : false;
    @endphp

    <div class="mt-6">
        <p><strong>Limit miejsc:</strong> {{ $event->max_participants }}</p>
        <p><strong>Zapisanych:</strong> {{ $participantsCount }}</p>

        @if(!is_null($freePlaces))
            <p><strong>Wolne miejsca:</strong> {{ max($freePlaces, 0) }}</p>
        @endif

        @auth
            @if($userAlreadyRegistered)
                <p class="text-success font-semibold mt-4">
                    Jesteś już zapisany/a na to wydarzenie.
                </p>
            @elseif($event->event_date < now())
                <p class="text-danger font-semibold mt-4">
                    Zapisy na to wydarzenie są już zakończone.
                </p>
            @elseif(!is_null($freePlaces) && $freePlaces <= 0)
                <p class="text-danger font-semibold mt-4">
                    Brak wolnych miejsc.
                </p>
            @else
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