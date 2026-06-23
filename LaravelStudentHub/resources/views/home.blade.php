<x-app-layout>
    <section class="text-center py-12">
        <h1 class="text-5xl font-bold mb-5">
            Witamy w <span class="text-primary">Student</span><span class="text-accent">Hub</span>!
        </h1>

        <p class="text-lg max-w-3xl mx-auto">
            Bądź na bieżąco z tym, co dzieje się na uczelni, zapisuj się na ulubione wydarzenia
            i współtwórz galerię wspomnień, dodając własne zdjęcia.
        </p>

        <p class="mt-4 text-lg">
            Dołącz do <span class="font-semibold text-primary">Student</span><span class="font-semibold text-accent">Hub</span>
            i bądź zawsze w centrum wydarzeń!
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 pb-12">
        <h2 class="text-3xl font-bold text-center mb-8">
            Nadchodzące wydarzenia
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div class="bg-white rounded shadow p-6 text-center">
                    <h3 class="text-xl font-bold mb-3">{{ $event->title }}</h3>

                    <p class="mb-3">
                        {{ Str::limit($event->description, 120) }}
                    </p>

                    <p><strong>Miejsce:</strong> {{ $event->location }}</p>
                    <p><strong>Data:</strong> {{ $event->start_date }}</p>

                    <a href="{{ route('events.show', $event) }}" class="text-blue-500 inline-block mt-3">
                        Czytaj więcej...
                    </a>
                </div>
            @empty
                <p class="col-span-3 text-center">
                    Brak wydarzeń.
                </p>
            @endforelse
        </div>
    </section>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-8 rounded shadow">
                <h1 class="text-3xl font-bold mb-4">
                    Portal wydarzeń uczelnianych
                </h1>

                <p class="mb-6">
                    Znajdź wydarzenia dla studentów i pracowników uczelni,
                    zapisz się na spotkania oraz śledź aktualności.
                </p>

                <div class="space-x-3">
                    <a href="{{ route('events.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Zobacz wydarzenia
                    </a>

                    <a href="{{ route('news.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
                        Aktualności
                    </a>

                    <a href="{{ route('contact.create') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
                        Kontakt
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="bg-green-600 text-white px-4 py-2 rounded">
                            Logowanie
                        </a>

                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded">
                            Rejestracja
                        </a>
                    @endguest
                </div>
            </div>

            <div class="mt-8 bg-white p-6 rounded shadow">
                <h2 class="text-2xl font-bold mb-4">Najbliższe wydarzenia</h2>

                @forelse($events as $event)
                    <div class="border-b py-3">
                        <h3 class="font-bold">{{ $event->title }}</h3>
                        <p>{{ $event->location }} | {{ $event->start_date }}</p>
                        <a href="{{ route('events.show', $event) }}" class="text-blue-600">
                            Szczegóły
                        </a>
                    </div>
                @empty
                    <p>Brak wydarzeń.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>