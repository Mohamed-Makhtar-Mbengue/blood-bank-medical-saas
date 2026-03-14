@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-blue-700">Nouvelle donation</h2>

        {{-- Bouton pour créer un nouveau donneur --}}
        <a href="{{ route('donors.create') }}"
           class="px-4 py-2 rounded-lg bg-green-600 text-white font-medium shadow hover:bg-green-700 transition">
            + Nouveau donneur
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-xl shadow-xl rounded-2xl border border-blue-100 p-8">

        <form action="{{ route('donations.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Donneur --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Donneur</label>

                <select id="donor_select" name="donor_id"
                        class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm">

                    @foreach($donors as $donor)
                        <option value="{{ $donor['id'] }}"
                                data-blood="{{ $donor['blood_type'] }}"
                                data-eligible="{{ $donor['eligible'] }}"
                                data-days="{{ $donor['days_left'] }}">

                            {{ $donor['name'] }} — {{ $donor['blood_type'] }}
                            @if($donor['eligible'])
                                (Éligible)
                            @else
                                (Encore {{ $donor['days_left'] }} jours)
                            @endif

                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Groupe sanguin (auto-rempli) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Groupe sanguin</label>
                <select id="blood_type" name="blood_type"
                        class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm">
                    @foreach(\App\Enums\BloodType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Quantité --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Quantité (ml)</label>
                <input type="number" name="quantity_ml" min="1"
                       class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm"
                       required>
            </div>

            {{-- Date du don --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date du don</label>
                <input type="date" name="donation_date"
                       class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm"
                       required>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (optionnel)</label>
                <textarea name="notes"
                          class="w-full px-4 py-2 border rounded-lg bg-white shadow-sm"></textarea>
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('donations.index') }}"
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

{{-- Script : auto-remplissage du groupe sanguin --}}
<script>
document.getElementById('donor_select').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const blood = selected.dataset.blood;

    document.getElementById('blood_type').value = blood;
});
</script>

@endsection
