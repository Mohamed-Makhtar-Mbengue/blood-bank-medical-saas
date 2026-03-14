@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h2 class="text-3xl font-bold text-blue-700 mb-6">
        Donneur : {{ $donor->name }}
    </h2>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 p-8 mb-10">

        <div class="grid grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-lg font-semibold">{{ $donor->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="text-lg font-semibold">{{ $donor->phone }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Groupe sanguin</p>
                <p class="text-lg font-semibold">{{ $donor->blood_type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Ville</p>
                <p class="text-lg font-semibold">{{ $donor->city }} ({{ $donor->postal_code }})</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Dernier don</p>
                <p class="text-lg font-semibold">
                    {{ $donor->last_donation_date?->format('d/m/Y') ?? '—' }}
                </p>
            </div>

        </div>

        <div class="flex justify-end gap-4 pt-6">

            <a href="{{ route('donors.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Retour
            </a>

            <form action="{{ route('donors.destroy', $donor) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce donneur ?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                    Supprimer
                </button>
            </form>

        </div>

    </div>

    {{-- Historique des dons --}}
    <h3 class="text-2xl font-bold text-blue-700 mb-4">Historique des donations</h3>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

        <table class="min-w-full text-left">
            <thead class="bg-blue-50 border-b border-blue-100">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold text-blue-700">Date</th>
                    <th class="px-6 py-4 text-sm font-semibold text-blue-700">Quantité</th>
                    <th class="px-6 py-4 text-sm font-semibold text-blue-700">Statut</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-blue-100">
                @forelse($donor->donations as $donation)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="px-6 py-4">{{ $donation->donation_date->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $donation->quantity_ml }} ml</td>
                        <td class="px-6 py-4">{{ ucfirst($donation->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Aucun don enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
