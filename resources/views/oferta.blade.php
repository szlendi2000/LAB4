@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Oferta</h1>

    <nav class="mb-6">
        <a href="/" class="text-blue-500 hover:underline">Główna</a> |
        <a href="/kontakt" class="text-blue-500 hover:underline">Kontakt</a> |
        <a href="/oferta" class="text-blue-500 hover:underline font-semibold">Oferta</a> |

        @guest
            <a href="/logowanie" class="text-blue-500 hover:underline">Logowanie</a>
        @endguest

        @auth
            <a href="/profil" class="text-blue-500 hover:underline">Profil</a> |
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-blue-500 hover:underline bg-transparent border-none p-0 cursor-pointer">
                    Wyloguj
                </button>
            </form>
        @endauth
    </nav>

    <p class="text-gray-700">Tu możesz opisać ofertę firmy.</p>
</div>
@endsection
