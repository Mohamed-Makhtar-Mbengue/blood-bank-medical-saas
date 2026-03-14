@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-blue-700">Liste des donations</h2>

        <div class="flex gap-3">
            <a href="{{ route('donors.index') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition">
                Voir les donneurs
            </a>
       
            <a href="{{ route('donors.create') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-green-700 transition">
                + Nouveau donneur
            </a>

            <a href="{{ route('donations.create') }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
                + Nouvelle donation
            </a>
        </div>
    </div>

    <form method="GET" action="{{ route('donations.index') }}" class="mb-8">

        <div class="flex flex-wrap items-end gap-6">

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Groupe sanguin</label>
                <select name="blood_type"
                    class="h-10 px-3 border rounded-xl bg-white shadow-sm w-40 text-sm">
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
                <label class="text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status"
                    class="h-10 px-3 border rounded-xl bg-white shadow-sm w-40 text-sm">
                    <option value="">Tous</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complété</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Date du don</label>
                <input type="date" name="date"
                    value="{{ request('date') }}"
                    class="h-10 px-3 border rounded-xl bg-white shadow-sm w-44 text-sm">
            </div>

            <button
                class="h-10 px-5 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition text-sm">
                Filtrer
            </button>

        </div>

    </form>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-left">
                <thead class="bg-blue-50 border-b border-blue-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Donneur</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Groupe</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Quantité</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Date</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Statut</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-100">
                    @foreach($donations as $donation)
                        <tr class="hover:bg-blue-50/50 transition">

                            <td class="px-6 py-4">{{ $donation->donor->name }}</td>
                            <td class="px-6 py-4">{{ $donation->blood_type }}</td>
                            <td class="px-6 py-4">{{ $donation->quantity_ml }} ml</td>
                            <td class="px-6 py-4">{{ $donation->donation_date->format('d/m/Y') }}</td>

                            <td class="px-6 py-4">
                                @if($donation->status === 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        Complété
                                    </span>
                                @elseif($donation->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-semibold">
                                        En attente
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                        Rejeté
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 flex items-center gap-3 justify-center">
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
