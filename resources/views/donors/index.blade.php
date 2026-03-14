@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="flex gap-3">
        <h2 class="text-3xl font-bold text-blue-700">Liste des donneurs</h2>
        <a href="{{ route('donations.index') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
            Voir les donations
        </a>
        <a href="{{ route('donations.create') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
            + Nouvelle donation
        </a>
        <a href="{{ route('donors.create') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow hover:bg-blue-700 transition">
            + Nouveau donneur
        </a>
    </div>
    <form method="GET" action="{{ route('donors.index') }}" class="mb-8">

            <div class="flex flex-wrap items-end gap-6">

                {{-- Nom --}}
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="name"
                        value="{{ request('name') }}"
                        class="h-10 px-3 border rounded-xl bg-white shadow-sm w-48 text-sm">
                </div>

                {{-- Groupe sanguin --}}
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

                {{-- Ville --}}
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" name="city"
                        value="{{ request('city') }}"
                        class="h-10 px-3 border rounded-xl bg-white shadow-sm w-44 text-sm">
                </div>

                {{-- Éligibilité --}}
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-700 mb-1">Éligibilité</label>
                    <select name="eligible"
                            class="h-10 px-3 border rounded-xl bg-white shadow-sm w-40 text-sm">
                        <option value="">Tous</option>
                        <option value="yes" {{ request('eligible') == 'yes' ? 'selected' : '' }}>Peut donner</option>
                        <option value="no" {{ request('eligible') == 'no' ? 'selected' : '' }}>Ne peut pas donner</option>
                    </select>
                </div>

                <button
                    class="h-10 px-5 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition text-sm">
                    Filtrer
                </button>

            </div>

        </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-left">
                <thead class="bg-blue-50 border-b border-blue-100">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Nom</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Email</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Téléphone</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Groupe</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Ville</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Code postal</th>
                        <th class="px-6 py-4 text-sm font-semibold text-blue-700">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-blue-100">
                    @foreach($donors as $donor)
                        <tr class="hover:bg-blue-50/50 transition">

                            <td class="px-6 py-4">{{ $donor->name }}</td>
                            <td class="px-6 py-4">{{ $donor->email }}</td>
                            <td class="px-6 py-4">{{ $donor->phone }}</td>
                            <td class="px-6 py-4">{{ $donor->blood_type }}</td>
                            <td class="px-6 py-4">{{ $donor->city ?? '—' }}</td>
                            <td class="px-6 py-4">{{ $donor->postal_code ?? '—' }}</td>

                            <td class="px-4 py-3 flex items-center gap-3 justify-center">
                                 <a href="{{ route('donors.show', $donor) }}"
                                class="px-3 py-1 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                                    Voir
                                </a>

                                <form action="{{ route('donors.destroy', $donor) }}" method="POST"
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
        {{ $donors->links() }}
    </div>

</div>

@endsection
