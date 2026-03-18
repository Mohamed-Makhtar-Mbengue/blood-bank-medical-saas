@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-300">Demandes d'urgence</h2>

    <a href="{{ route('emergencies.create') }}"
       class="px-3 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition text-sm">
        Nouvelle demande
    </a>
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

{{-- TABLEAU --}}
<div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl border border-blue-100 dark:border-gray-700 overflow-hidden">

    <div class="overflow-x-auto w-full">

        <table class="w-full border-collapse rounded-xl overflow-hidden">

            <thead class="bg-blue-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">PATIENT</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">GROUPE</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">NIVEAU</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">QTE</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">DATE</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 text-center whitespace-nowrap">ACTIONS</th>
                    <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 whitespace-nowrap">STOCK</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-blue-100 dark:divide-gray-700">

                @foreach ($emergencies as $emergency)
                    <tr class="{{ $loop->even ? 'bg-blue-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">

                        <td class="px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
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

                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                            {{ $emergency->quantity_ml }} ml
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
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

@endsection
