@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-8">
    Tableau de bord – Statistiques
</h1>

{{-- Cartes principales --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Donneurs</h3>
        <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $donors }}</p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Stock total (ml)</h3>
        <p class="text-4xl font-bold text-green-600 dark:text-green-400">
            {{ $stockByType->sum('total') }}
        </p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-gray-700 dark:text-gray-300 font-semibold">Groupes sanguins</h3>
        <p class="text-4xl font-bold text-red-600 dark:text-red-400">
            {{ $stockByType->count() }}
        </p>
    </div>

</div>

{{-- Graphiques --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    {{-- Stock par groupe sanguin --}}
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Stock par groupe sanguin</h3>
        <div id="chartBloodType"></div>
    </div>

    {{-- Statuts des poches --}}
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Statuts des poches</h3>
        <div id="chartStatus"></div>
    </div>

    {{-- Dons par mois --}}
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Dons par mois</h3>
        <div id="chartDonations"></div>
    </div>

    {{-- Urgences par mois --}}
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Urgences par mois</h3>
        <div id="chartEmergencies"></div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="/js/statistics.js"></script>

@endsection
