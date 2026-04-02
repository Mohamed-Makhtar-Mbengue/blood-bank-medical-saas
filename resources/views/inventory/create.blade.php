@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-8">
        Ajouter une poche de sang
    </h2>

    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 dark:border-gray-700 p-8">

        <form action="{{ route('inventory.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Groupe sanguin --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Groupe sanguin
                </label>
                <select name="blood_type"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                               bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                               shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach(\App\Enums\BloodType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Quantité --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Quantité (ml)
                </label>
                <input type="number" name="quantity_ml" min="1"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                              shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            {{-- Date d’expiration --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Date d’expiration
                </label>
                <input type="date" name="expiration_date"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                              shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Statut
                </label>
                <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                               bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                               shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="available">Disponible</option>
                    <option value="used">Utilisé</option>
                </select>
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('inventory.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 
                          text-gray-700 dark:text-gray-200 font-medium 
                          hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Annuler
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    Ajouter
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
