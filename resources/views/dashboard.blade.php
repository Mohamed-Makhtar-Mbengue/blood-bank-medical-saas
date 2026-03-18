@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6">
    Tableau de bord
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Urgences</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Gérez les demandes urgentes.</p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Stock</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Consultez les niveaux de sang.</p>
    </div>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Donneurs</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Gérez les donneurs et donations.</p>
    </div>

</div>

@endsection
