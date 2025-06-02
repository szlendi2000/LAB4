@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <h1 class="text-3xl font-bold mb-4 flex items-center justify-between">
        Profil użytkownika
        <a href="{{ url('/profil/panel') }}" 
           class="ml-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
            Panel
        </a>
    </h1>

    <nav class="mb-6">
        <a href="/" class="text-blue-500 hover:underline">Główna</a> |
        <a href="/kontakt" class="text-blue-500 hover:underline">Kontakt</a> |
        <a href="/oferta" class="text-blue-500 hover:underline">Oferta</a> |
        @guest
            <a href="/logowanie" class="text-blue-500 hover:underline">Logowanie</a> |
        @endguest

        @auth
            <a href="/profil" class="text-blue-500 hover:underline font-semibold">Profil</a> |
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-blue-500 hover:underline bg-transparent border-0 p-0 m-0 cursor-pointer align-baseline">
                    Wyloguj
                </button>
            </form>
        @endauth
    </nav>
    <p class="text-gray-700 mb-6">
        Ta strona jest dostępna tylko dla zalogowanych użytkowników.
    </p>

    <div class="flex gap-6">
        <!-- Lewa kolumna: lista komponentów -->
        <aside class="w-1/3 p-4 border border-gray-300 rounded shadow-sm bg-white max-h-[600px] overflow-auto">
            <h2 class="text-2xl font-semibold mb-4">Aktywne komponenty</h2>

            @if(!empty($components))
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($components as $component)
                        <li>
                            <span class="font-medium">{{ $component->getName() }}</span>
                            <small class="text-gray-500">({{ $component->getSlug() }})</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">Brak aktywnych komponentów do wyświetlenia.</p>
            @endif
        </aside>

        <!-- Prawa kolumna: miejsce na inne treści -->
        <section class="flex-1 p-4 border border-gray-300 rounded shadow-sm bg-white max-h-[600px] overflow-auto">
            <h2 class="text-2xl font-semibold mb-4">Szczegóły / Inne treści</h2>
            <p class="text-gray-600">Tutaj możesz dodać dodatkowe informacje lub szczegóły wybranego komponentu.</p>
        </section>
    </div>

    <a href="{{ url('/admin/modules/install') }}" 
       class="mt-8 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
        Przejdź do instalacji modułów
    </a>
</div>
@endsection
