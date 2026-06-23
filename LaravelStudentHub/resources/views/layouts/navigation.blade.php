<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-5 py-2 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('content/logo-appname.png') }}" alt="StudentHub" class="h-12">
        </a>

        <nav class="flex items-center gap-8">
            <a href="{{ route('news.index') }}" class="font-semibold text-primary">
                Aktualności
            </a>

            <a href="{{ route('events.index') }}" class="font-semibold text-accent">
                Wydarzenia
            </a>

            <a href="{{ route('contact.create') }}" class="font-semibold text-primary">
                Kontakt
            </a>

            @guest
                <a href="{{ route('register') }}" class="font-semibold text-accent">Rejestracja</a>
            @endguest

            @guest
                <a href="{{ route('login') }}" class="bg-primary text-white px-5 py-2 rounded-lg font-semibold">
                    <i class="bi bi-person-circle"></i>
                    <span>Zaloguj się</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-primary text-white px-5 py-2 rounded-lg font-semibold">
                    Panel
                </a>
            @endguest
        </nav>
    </div>
</header>