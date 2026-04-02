@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-300">Demandes d'urgence</h2>

    <a href="{{ route('emergencies.create') }}"
       class="px-3 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition text-sm">
        Nouvelle demande
    </a>
</div>

{{-- DASHBOARD URGENCES --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Total urgences</h3>
        <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $totalEmergencies }}</p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Ce mois</h3>
        <p class="text-4xl font-bold text-orange-500 dark:text-orange-400">{{ $emergenciesThisMonth }}</p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Types d’urgences</h3>
        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $emergenciesByType->count() }}</p>
    </div>

</div>

{{-- GRAPHIQUES --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Urgences par niveau</h3>
        <div id="chartEmergencyType"></div>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Urgences par mois</h3>
        <div id="chartEmergencyMonth"></div>
    </div>

</div>

{{-- FILTRE --}}
<form method="GET" class="mb-6 flex gap-3 items-center">

    <select name="blood_type"
            class="px-3 py-2 border rounded-lg bg-white dark:bg-gray-800
                   text-gray-700 dark:text-gray-200 border-blue-200 dark:border-gray-600 shadow-sm">
        <option value="">Tous les groupes</option>

        @foreach(\App\Enums\BloodType::cases() as $type)
            <option value="{{ $type->value }}"
                {{ request('blood_type') === $type->value ? 'selected' : '' }}>
                {{ $type->value }}
            </option>
        @endforeach
    </select>

    <button class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-400 transition">
        Filtrer
    </button>

</form>

{{-- TABLEAU RESPONSIVE PREMIUM --}}
<div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl border border-blue-100 dark:border-gray-700">

    {{-- WRAPPER RESPONSIVE --}}
    <div class="overflow-x-auto rounded-2xl">

        <table class="min-w-full text-sm">

            {{-- HEADER STICKY --}}
            <thead class="bg-blue-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">PATIENT</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">GROUPE</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">NIVEAU</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">QTE</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">DATE</th>
                    <th class="px-4 py-3 text-center font-semibold whitespace-nowrap">ACTIONS</th>
                    <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">STOCK</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-blue-100 dark:divide-gray-700">

                @foreach ($emergencies as $emergency)
                    <tr class="{{ $loop->even ? 'bg-blue-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">

                        <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            {{ $emergency->patient_name }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded bg-red-200 text-red-800 dark:bg-red-800 dark:text-red-200 text-xs font-semibold">
                                {{ $emergency->blood_type }}
                            </span>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($emergency->emergency_level === 'high')
                                <span class="px-2 py-0.5 rounded bg-red-300 text-red-900 dark:bg-red-700 dark:text-red-200 text-xs font-semibold">Critique</span>
                            @elseif ($emergency->emergency_level === 'medium')
                                <span class="px-2 py-0.5 rounded bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200 text-xs font-semibold">Moyenne</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200 text-xs font-semibold">Faible</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            {{ $emergency->quantity_ml }} ml
                        </td>

                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            {{ $emergency->created_at->format('d/m H:i') }}
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex gap-1 justify-center">

                                <a href="{{ route('emergencies.show', $emergency->id) }}"
                                   class="px-2 py-1 rounded bg-blue-600 text-white text-xs font-medium hover:bg-blue-700 transition">
                                    Voir
                                </a>

                                <form action="{{ route('emergencies.destroy', $emergency->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-red-600 text-white text-xs font-medium hover:bg-red-700 transition">
                                        Supprimer
                                    </button>
                                </form>

                            </div>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($emergency->hasEnoughStock())
                                <span class="px-2 py-1 bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200 rounded-lg text-xs font-semibold">
                                    Stock suffisant
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-200 text-red-800 dark:bg-red-800 dark:text-red-200 rounded-lg text-xs font-semibold">
                                    Stock insuffisant
                                </span>
                            @endif
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</div>

<div class="mt-4">
    {{ $emergencies->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="/js/emergency-stats.js"></script>

@endsection
