@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold text-blue-700 mb-6">Nouveau donneur</h2>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 p-8">

        <form action="{{ route('donors.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Téléphone --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Date de naissance (OBLIGATOIRE) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date de naissance</label>
                <input type="date" name="birth_date"
                       class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm"
                       required>
            </div>

            {{-- Groupe sanguin --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Groupe sanguin</label>
                <select name="blood_type" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
                    @foreach(\App\Enums\BloodType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Adresse --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse</label>
                <input type="text" name="address" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Ville --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ville</label>
                <input type="text" name="city" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Code postal --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Code postal</label>
                <input type="text" name="postal_code" class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm" required>
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('donors.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition">
                    Annuler
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    Enregistrer
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
