<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            StudentHub - wydarzenia uczelniane
        </h2>
    </x-slot>

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