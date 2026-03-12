@extends('layouts.app')

@section('content')

<div class="px-4 sm:px-6 lg:px-8">
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6 sm:p-8">

<h1 class="text-xl sm:text-2xl font-bold mb-6 text-gray-800">
Nouvelle demande d'urgence
</h1>

<form method="POST"
action="{{ route('emergencies.store') }}"
class="space-y-6">

@csrf

{{-- Patient --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Nom du patient
</label>

<input type="text"
name="patient_name"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
required>
</div>

{{-- Groupe sanguin --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Groupe sanguin
</label>

<select name="blood_type"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">

@foreach(\App\Enums\BloodType::cases() as $type)
<option value="{{ $type->value }}">
{{ $type->value }}
</option>
@endforeach

</select>
</div>

{{-- Niveau --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Niveau d'urgence
</label>

<select name="emergency_level"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">

@foreach($emergencyLevels as $level)
<option value="{{ $level->value }}">
{{ ucfirst($level->value) }}
</option>
@endforeach

</select>
</div>

{{-- Quantité --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Quantité (ml)
</label>

<input type="number"
name="quantity_ml"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
required>
</div>

{{-- Hôpital --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Hôpital
</label>

<textarea name="hospital_details"
rows="3"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
</div>

{{-- Notes --}}
<div>
<label class="block text-sm font-medium text-gray-700">
Notes (optionnel)
</label>

<textarea name="notes"
rows="3"
class="mt-1 w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
</div>

<div class="pt-4">
<x-button color="green" type="submit" class="w-full sm:w-auto">
Enregistrer la demande
</x-button>
</div>

</form>

</div>
</div>

@endsection