@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-8">
    <h2 class="text-3xl font-bold text-blue-700">Demandes d'urgence</h2>

    <a href="{{ route('emergencies.create') }}"
       class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
        Nouvelle demande
    </a>
</div>

<div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">
    <table class="w-full text-left table-fixed">
        <thead class="bg-blue-50 border-b border-blue-100">
            <tr>
                <th class="px-6 py-4 w-1/5 text-sm font-semibold text-blue-700">PATIENT</th>
                <th class="px-6 py-4 w-1/6 text-sm font-semibold text-blue-700">GROUPE</th>
                <th class="px-6 py-4 w-1/6 text-sm font-semibold text-blue-700">NIVEAU</th>
                <th class="px-6 py-4 w-1/6 text-sm font-semibold text-blue-700">QUANTITÉ</th>
                <th class="px-6 py-4 w-1/6 text-sm font-semibold text-blue-700">DATE</th>
                <th class="px-6 py-4 w-24 text-sm font-semibold text-blue-700 text-center">ACTIONS</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-100">
            @foreach ($emergencies as $emergency)
                <tr class="hover:bg-blue-50/50 transition">

                    <!-- Patient -->
                    <td class="px-6 py-4 font-medium text-gray-700">
                        {{ $emergency->patient_name }}
                    </td>

                    <!-- Groupe sanguin -->
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-lg bg-red-100 text-red-700 font-semibold">
                            {{ $emergency->blood_type }}
                        </span>
                    </td>

                    <!-- Niveau d'urgence -->
                    <td class="px-6 py-4">
                        @if ($emergency->urgency_level === 'High')
                            <span class="px-3 py-1 rounded-lg bg-red-200 text-red-800 font-semibold">
                                High
                            </span>
                        @elseif ($emergency->urgency_level === 'Medium')
                            <span class="px-3 py-1 rounded-lg bg-yellow-200 text-yellow-800 font-semibold">
                                Medium
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-lg bg-green-200 text-green-800 font-semibold">
                                Low
                            </span>
                        @endif
                    </td>

                    <!-- Quantité -->
                    <td class="px-6 py-4 text-gray-700">
                        {{ $emergency->quantity }} ml
                    </td>

                    <!-- Date -->
                    <td class="px-6 py-4 text-gray-700">
                        {{ $emergency->date }}
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('emergencies.show', $emergency->id) }}"
                           class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition">
                            Voir
                        </a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
