@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <h1 class="text-3xl font-bold mb-6">Panel zarządzania komponentami</h1>

    @if(session('status'))
        <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if(isset($components) && count($components) > 0)
        <table class="w-full border border-gray-300 rounded shadow-sm bg-white">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-300">
                    <th class="p-3 text-left">Nazwa komponentu</th>
                    <th class="p-3 text-left">Włączony</th>
                    <th class="p-3 text-left">Akcja</th>
                </tr>
            </thead>
            <tbody>
                @foreach($components as $component)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <td class="p-3 align-middle">{{ $component->getName() }}</td>
                    <td class="p-3 align-middle">{{ $component->isEnabled() ? 'Tak' : 'Nie' }}</td>
                    <td class="p-3 align-middle">
                        <form method="POST" action="{{ route('profil.components.toggle') }}">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $component->getSlug() }}">
                            <select name="enable" class="border rounded px-2 py-1">
                                <option value="1" @if($component->isEnabled()) selected @endif>Włącz</option>
                                <option value="0" @if(!$component->isEnabled()) selected @endif>Wyłącz</option>
                            </select>
                            <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded transition">
                                Zapisz
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Brak dostępnych komponentów.</p>
    @endif

    <a href="{{ route('profil') }}"
       class="mt-8 inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded transition">
        Powrót do profilu
    </a>
</div>
@endsection
