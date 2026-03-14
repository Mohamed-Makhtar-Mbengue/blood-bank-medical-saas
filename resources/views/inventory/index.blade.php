@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-blue-700">Stock de sang</h2>

        <a href="{{ route('inventory.create') }}"
           class="px-3 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition text-sm">
            Ajouter une poche
        </a>
    </div>

    @if($inventories->contains(fn($i) => $i->isLowStock() || $i->isExpiringSoon()))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
            ⚠️ Certaines poches ont un stock faible ou expirent bientôt.
        </div>
    @endif

    <form method="GET" class="mb-6 flex gap-3 items-center">
        <select name="blood_type"
                class="px-3 py-2 border rounded-lg bg-white shadow-sm">
            <option value="">Tous les groupes</option>

            @foreach(\App\Enums\BloodType::cases() as $type)
                <option value="{{ $type->value }}"
                    {{ request('blood_type') === $type->value ? 'selected' : '' }}>
                    {{ $type->value }}
                </option>
            @endforeach
        </select>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Filtrer
        </button>
    </form>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-left">
                <thead class="bg-blue-50 border-b border-blue-100">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-blue-700">GROUPE</th>
                        <th class="px-4 py-3 text-xs font-semibold text-blue-700">QTE</th>
                        <th class="px-4 py-3 text-xs font-semibold text-blue-700">EXPIRATION</th>
                        <th class="px-4 py-3 text-xs font-semibold text-blue-700">STATUT</th>
                        <th class="px-4 py-3 text-xs font-semibold text-blue-700 text-center">ACTIONS</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-100">
                    @foreach($inventories as $item)
                        <tr class="hover:bg-blue-50/50 transition">

                            <td class="px-4 py-3">{{ $item->blood_type }}</td>
                            <td class="px-4 py-3">{{ $item->quantity_ml }} ml</td>
                            <td class="px-4 py-3">{{ $item->expiration_date?->format('d/m/Y') ?? '—' }}</td>

                            <td class="px-4 py-3">
                                @if($item->isLowStock())
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">Stock faible</span>
                                @elseif($item->isExpiringSoon())
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">Expire bientôt</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">OK</span>
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
