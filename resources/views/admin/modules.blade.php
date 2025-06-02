@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Zarządzanie komponentami</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-6 py-3 text-sm font-medium text-gray-700">Nazwa</th>
                <th class="px-6 py-3 text-sm font-medium text-gray-700">Wersja</th>
                <th class="px-6 py-3 text-sm font-medium text-gray-700">Opis</th>
                <th class="px-6 py-3 text-sm font-medium text-gray-700">Status</th>
                <th class="px-6 py-3 text-sm font-medium text-gray-700">Akcja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $module->name }}</td>
                    <td class="px-6 py-4">{{ $module->version }}</td>
                    <td class="px-6 py-4">{{ $module->description }}</td>
                    <td class="px-6 py-4">
                        @if ($module->enabled)
                            <span class="text-green-600 font-semibold">Włączony</span>
                        @else
                            <span class="text-red-600 font-semibold">Wyłączony</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if (!$module->enabled)
                            <form action="{{ route('modules.enable', $module->slug) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Włącz
                                </button>
                            </form>
                        @else
                            <form action="{{ route('modules.disable', $module->slug) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Wyłącz
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
