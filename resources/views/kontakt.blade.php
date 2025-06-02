@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Kontakt</h1>

    <nav class="mb-6">
        <a href="/" class="text-blue-500 hover:underline">Główna</a> |
        <a href="/kontakt" class="text-blue-500 hover:underline font-semibold">Kontakt</a> |
        <a href="/oferta" class="text-blue-500 hover:underline">Oferta</a> |

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

    {{-- Komunikat o sukcesie --}}
    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    {{-- Formularz kontaktowy --}}
    <form method="POST" action="/kontakt" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Imię:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2">
            @error('name')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded px-3 py-2">
            @error('email')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <div>
            <label class="block font-semibold">Wiadomość:</label>
            <textarea name="message" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('message') }}</textarea>
            @error('message')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Wyślij</button>
    </form>

    <p class="mt-6 text-gray-600">Tu możesz umieścić dane kontaktowe.</p>
</div>
@endsection
