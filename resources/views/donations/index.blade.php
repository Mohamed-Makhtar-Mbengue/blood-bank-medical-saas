@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300">Liste des donations</h2>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('donors.index') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition">
                Voir les donneurs
            </a>

            <a href="{{ route('donors.create') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition">
                + Nouveau donneur
            </a>

            <a href="{{ route('donations.create') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition">
                + Nouvelle donation
            </a>
        </div>
    </div>

    <!-- FILTRES -->
    <form method="GET" action="{{ route('donations.index') }}" class="mb-8">

        <div class="flex flex-wrap items-end gap-6">

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Groupe sanguin</label>
                <select name="blood_type"
                    class="h-10 px-3 border rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200
                           border-blue-200 dark:border-gray-600 shadow-sm w-40 text-sm">
                    <option value="">Tous</option>
                    @foreach(\App\Enums\BloodType::cases() as $type)
                        <option value="{{ $type->value }}"
                            {{ request('blood_type') == $type->value ? 'selected' : '' }}>
                            {{ $type->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Statut</label>
                <select name="status"
                    class="h-10 px-3 border rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200
                           border-blue-200 dark:border-gray-600 shadow-sm w-40 text-sm">
                    <option value="">Tous</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complété</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date du don</label>
                <input type="date" name="date"
                    value="{{ request('date') }}"
                    class="h-10 px-3 border rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200
                           border-blue-200 dark:border-gray-600 shadow-sm w-44 text-sm">
            </div>

            <button
                class="h-10 px-5 bg-blue-600 dark:bg-blue-500 text-white rounded-xl shadow hover:bg-blue-700 dark:hover:bg-blue-400 transition text-sm">
                Filtrer
            </button>

        </div>

    </form>

    <!-- TABLEAU RESPONSIVE PREMIUM -->
    <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl border border-blue-100 dark:border-gray-700">

        <!-- WRAPPER RESPONSIVE -->
        <div class="overflow-x-auto rounded-2xl">

            <table class="min-w-full text-sm">

                <!-- HEADER STICKY -->
                <thead class="bg-blue-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Donneur</th>
                        <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Groupe</th>
                        <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Quantité</th>
                        <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Date</th>
                        <th class="px-6 py-4 text-left font-semibold whitespace-nowrap">Statut</th>
                        <th class="px-6 py-4 text-center font-semibold whitespace-nowrap">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-100 dark:divide-gray-700">

                    @foreach($donations as $donation)
                        <tr class="{{ $loop->even ? 'bg-blue-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                {{ $donation->donor->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                {{ $donation->blood_type }}
                            </td>

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                {{ $donation->quantity_ml }} ml
                            </td>

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                {{ $donation->donation_date->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($donation->status === 'completed')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200 rounded-lg text-xs font-semibold">
                                        Complété
                                    </span>
                                @elseif($donation->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200 rounded-lg text-xs font-semibold">
                                        En attente
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 dark:bg-red-800 dark:text-red-200 rounded-lg text-xs font-semibold">
                                        Rejeté
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 flex items-center gap-3 justify-center whitespace-nowrap">

                                <a href="{{ route('donations.show', $donation) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                    Voir
                                </a>

                                <form action="{{ route('donations.destroy', $donation) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette donation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition">
                                        Supprimer
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-6">
        {{ $donations->links() }}
    </div>

</div>

@endsection
