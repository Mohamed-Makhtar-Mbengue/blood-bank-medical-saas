@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Demandes d'urgence</h2>

    <a href="{{ route('emergencies.create') }}"
       class="px-3 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition text-sm">
        Nouvelle demande
    </a>
</div>

{{-- FILTRE --}}
<form method="GET" class="mb-6 flex gap-3 items-center">
    <select name="blood_type"
            class="px-3 py-2 border rounded-lg bg-white shadow-sm">
        <option value="">Tous les groupes</option>

        @foreach(\App\Enums\BloodType::cases() as $type)
            <option value="{{ $type->value }}"
                {{ request('blood_type') === $type->value ? 'selected' : '' }}>
                {{ $type->value }}
            </option>
        @endforeach
    </select>

    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Filtrer
    </button>
</form>

<div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-left">
            <thead class="bg-blue-50 border-b border-blue-100">
                <tr>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">PATIENT</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">GROUPE</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">NIVEAU</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">QTE</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">DATE</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 text-center whitespace-nowrap">ACTIONS</th>
                    <th class="px-4 py-3 text-xs font-semibold text-blue-700 whitespace-nowrap">QUANTITE</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-blue-100">
                @foreach ($emergencies as $emergency)
                    <tr class="hover:bg-blue-50/50 transition">

                        <td class="px-4 py-3 text-sm font-medium text-gray-700 whitespace-nowrap">
                            {{ $emergency->patient_name }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded bg-red-100 text-red-700 text-xs font-semibold">
                                {{ $emergency->blood_type }}
                            </span>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($emergency->emergency_level === 'high')
                                <span class="px-2 py-0.5 rounded bg-red-200 text-red-800 text-xs font-semibold">Critique</span>
                            @elseif ($emergency->emergency_level === 'medium')
                                <span class="px-2 py-0.5 rounded bg-yellow-200 text-yellow-800 text-xs font-semibold">Moyenne</span>
                            @else
                                <span class="px-2 py-0.5 rounded bg-green-200 text-green-800 text-xs font-semibold">Faible</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ $emergency->quantity_ml }} ml
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                            {{ $emergency->created_at->format('d/m H:i') }}
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex gap-1 justify-center">

                                <a href="{{ route('emergencies.show', $emergency->id) }}"
                                   class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-medium hover:bg-blue-200 transition">
                                    Voir
                                </a>

                                <form action="{{ route('emergencies.destroy', $emergency->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-medium hover:bg-red-200 transition">
                                        Supprimer
                                    </button>
                                </form>

                            </div>
                        </td>
                        <td>
                            @if($emergency->hasEnoughStock())
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                    Stock suffisant
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
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
