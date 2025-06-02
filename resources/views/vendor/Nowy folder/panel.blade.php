@extends('layouts.app')

@section('content')
<div class="flex container mx-auto px-4 py-6 space-x-6">
    {{-- Lewy sidebar z listą komponentów --}}
    <aside class="w-1/4 bg-gray-100 p-4 rounded shadow">
        <h2 class="font-bold text-xl mb-4">Komponenty</h2>
        <ul>
            @foreach($components as $component)
                <li class="mb-3 flex items-center justify-between">
                    <a href="{{ route('profil.panel', ['component' => $component->getSlug()]) }}" 
                       class="text-blue-600 hover:underline {{ $selectedComponent && $selectedComponent->getSlug() === $component->getSlug() ? 'font-bold' : '' }}">
                        {{ $component->getName() }}
                    </a>

                    {{-- Form do włączania/wyłączania --}}
                    <form method="POST" action="{{ route('profil.panel.toggle') }}">
                        @csrf
                        <input type="hidden" name="slug" value="{{ $component->getSlug() }}">
                        <input type="hidden" name="enable" value="{{ $component->isEnabled() ? 0 : 1 }}">
                        <button type="submit" 
                            class="text-sm rounded px-2 py-1 {{ $component->isEnabled() ? 'bg-green-500 text-white' : 'bg-gray-300' }}">
                            {{ $component->isEnabled() ? 'Włączony' : 'Wyłączony' }}
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- Główna zawartość dla wybranego komponentu --}}
    <main class="flex-1 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">
            {{ $selectedComponent ? $selectedComponent->getName() : 'Brak wybranego komponentu' }}
        </h1>

        @if ($selectedComponent)
            <p>Tu możesz wyświetlić zawartość komponentu <strong>{{ $selectedComponent->getSlug() }}</strong>.</p>
            {{-- Tu możesz ładować widoki komponentu lub inne dane --}}
        @else
            <p>Wybierz komponent z listy po lewej.</p>
        @endif
    </main>
</div>
@endsection
