@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8">

<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6 sm:p-8">

<h1 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
    Détail de la demande
</h1>

<div class="space-y-4 text-gray-700 dark:text-gray-200">

    <p>
        <span class="font-semibold">Patient :</span>
        {{ $emergency->patient_name }}
    </p>

    <p>
        <span class="font-semibold">Groupe sanguin :</span>
        {{ $emergency->blood_type->value }}
    </p>

    <p>
        <span class="font-semibold">Niveau :</span>
        <x-badge :type="$emergency->emergency_level->value"/>
    </p>

    <p>
        <span class="font-semibold">Quantité :</span>
        {{ $emergency->quantity_ml }} ml
    </p>

    <p>
        <span class="font-semibold">Date :</span>
        {{ $emergency->created_at->format('d/m/Y') }}
    </p>

</div>

<div class="mt-6">
    <x-button color="blue" :href="route('emergencies.index')">
        Retour
    </x-button>
</div>

</div>

</div>

@endsection
