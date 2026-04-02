@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8">
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 shadow rounded-lg p-6 sm:p-8">

<h1 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Nouvelle demande d'urgence
</h1>

{{-- Messages d’erreur --}}
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('emergencies.store') }}" class="space-y-6">
    @csrf

    {{-- Patient --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom du patient</label>
        <input type="text" name="patient_name"
               class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500"
               required>
    </div>

    {{-- Groupe sanguin --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Groupe sanguin</label>
        <select name="blood_type"
                class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @foreach(\App\Enums\BloodType::cases() as $type)
                <option value="{{ $type->value }}">{{ $type->value }}</option>
            @endforeach
        </select>
    </div>

    {{-- Niveau --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Niveau d'urgence</label>
        <select name="emergency_level"
                class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @foreach($emergencyLevels as $level)
                <option value="{{ $level->value }}">{{ ucfirst($level->value) }}</option>
            @endforeach
        </select>
    </div>

    {{-- Quantité --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantité (ml)</label>
        <input type="number" name="quantity_ml"
               class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500"
               required>
    </div>

    {{-- Hôpital --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hôpital</label>
        <textarea name="hospital_details" rows="3"
                  class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    {{-- Notes --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes (optionnel)</label>
        <textarea name="notes" rows="3"
                  class="mt-1 w-full border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    {{-- Boutons --}}
    <div class="pt-4 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('emergencies.index') }}"
            class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700 transition text-center">
            Annuler la demande
        </a>
        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition text-center">
            Enregistrer la demande
        </button>
    </div>

</form>

</div>
</div>

@endsection
