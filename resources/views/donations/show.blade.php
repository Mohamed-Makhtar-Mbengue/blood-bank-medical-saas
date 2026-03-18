@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6">
        Détail de la donation
    </h2>

    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-xl rounded-2xl 
                border border-blue-100 dark:border-gray-700 p-8 space-y-6">

        <div class="grid grid-cols-2 gap-6 text-gray-700 dark:text-gray-200">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Donneur</p>
                <p class="text-lg font-semibold">{{ $donation->donor->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Groupe sanguin</p>
                <p class="text-lg font-semibold">{{ $donation->blood_type }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Quantité</p>
                <p class="text-lg font-semibold">{{ $donation->quantity_ml }} ml</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Date du don</p>
                <p class="text-lg font-semibold">{{ $donation->donation_date->format('d/m/Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Statut</p>
                <span class="px-3 py-1 rounded-lg 
                             bg-green-200 dark:bg-green-700 
                             text-green-800 dark:text-green-100 
                             font-semibold">
                    {{ ucfirst($donation->status) }}
                </span>
            </div>

        </div>

        @if($donation->notes)
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                <p class="text-gray-700 dark:text-gray-200">{{ $donation->notes }}</p>
            </div>
        @endif

        <div class="flex justify-end gap-4 pt-4">

            <a href="{{ route('donations.index') }}"
               class="px-4 py-2 rounded-lg 
                      bg-gray-200 dark:bg-gray-700 
                      text-gray-700 dark:text-gray-200 
                      hover:bg-gray-300 dark:hover:bg-gray-600">
                Retour
            </a>

            <form action="{{ route('donations.destroy', $donation) }}" method="POST"
                  onsubmit="return confirm('Supprimer cette donation ?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 rounded-lg 
                               bg-red-600 dark:bg-red-700 
                               text-white hover:bg-red-700 dark:hover:bg-red-800">
                    Supprimer
                </button>
            </form>

        </div>

    </div>

</div>

@endsection
