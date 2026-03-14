@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold text-blue-700 mb-6">
        Détail de la donation
    </h2>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 p-8 space-y-6">

        <div class="grid grid-cols-2 gap-6">

            <div>
                <p class="text-sm text-gray-500">Donneur</p>
                <p class="text-lg font-semibold">{{ $donation->donor->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Groupe sanguin</p>
                <p class="text-lg font-semibold">{{ $donation->blood_type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Quantité</p>
                <p class="text-lg font-semibold">{{ $donation->quantity_ml }} ml</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Date du don</p>
                <p class="text-lg font-semibold">{{ $donation->donation_date->format('d/m/Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <span class="px-3 py-1 rounded-lg bg-green-200 text-green-800 font-semibold">
                    {{ ucfirst($donation->status) }}
                </span>
            </div>

        </div>

        @if($donation->notes)
            <div>
                <p class="text-sm text-gray-500">Notes</p>
                <p class="text-gray-700">{{ $donation->notes }}</p>
            </div>
        @endif

        <div class="flex justify-end gap-4 pt-4">

            <a href="{{ route('donations.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Retour
            </a>

            <form action="{{ route('donations.destroy', $donation) }}" method="POST"
                  onsubmit="return confirm('Supprimer cette donation ?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                    Supprimer
                </button>
            </form>

        </div>

    </div>

</div>

@endsection
