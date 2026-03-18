@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-300">Stock de sang</h2>

        <a href="{{ route('inventory.create') }}"
           class="px-3 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition text-sm">
            Ajouter une poche
        </a>
    </div>

    <!-- ALERTES -->
    @if($inventories->contains(fn($i) => $i->isLowStock() || $i->isExpiringSoon()))
        <div class="mb-4 p-4 bg-red-200 dark:bg-red-800 text-red-800 dark:text-red-200 rounded-lg shadow">
            ⚠️ Certaines poches ont un stock faible ou expirent bientôt.
        </div>
    @endif

    <!-- FILTRES -->
    <form method="GET" class="mb-6 flex gap-3 items-center">

        <select name="blood_type"
                class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200
                       border border-blue-200 dark:border-gray-600
                       rounded-lg px-3 py-2 shadow-sm transition">
            <option value="">Tous les groupes</option>

            @foreach(\App\Enums\BloodType::cases() as $type)
                <option value="{{ $type->value }}"
                    {{ request('blood_type') === $type->value ? 'selected' : '' }}>
                    {{ $type->value }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 dark:bg-blue-500 text-white font-medium
                       px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-400 transition">
            Filtrer
        </button>

    </form>

    <!-- TABLEAU -->
    <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl border border-blue-100 dark:border-gray-700 overflow-hidden">

        <div class="overflow-x-auto w-full">

            <table class="w-full border-collapse rounded-xl overflow-hidden">

                <thead class="bg-blue-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600">GROUPE</th>
                        <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600">QTE</th>
                        <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600">EXPIRATION</th>
                        <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600">STATUT</th>
                        <th class="px-4 py-3 text-left font-semibold border-b border-blue-300 dark:border-gray-600 text-center">ACTIONS</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-100 dark:divide-gray-700">

                    @foreach($inventories as $item)
                        <tr class="{{ $loop->even ? 'bg-blue-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }}">

                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ $item->blood_type }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ $item->quantity_ml }} ml
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ $item->expiration_date?->format('d/m/Y') ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                @if($item->isLowStock())
                                    <span class="px-2 py-1 bg-red-200 text-red-800 dark:bg-red-800 dark:text-red-200 rounded-lg text-xs font-semibold">
                                        Stock faible
                                    </span>
                                @elseif($item->isExpiringSoon())
                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200 rounded-lg text-xs font-semibold">
                                        Expire bientôt
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200 rounded-lg text-xs font-semibold">
                                        OK
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 flex items-center gap-3 justify-center">

                                <a href="{{ route('inventory.show', $item) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                    Voir
                                </a>

                                <form action="{{ route('inventory.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cet élément du stock ?')">
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

</div>

@endsection
