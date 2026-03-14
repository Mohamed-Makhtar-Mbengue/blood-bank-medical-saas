<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\BloodType;
use App\Enums\EmergencyLevel;

class StoreEmergencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => ['required', 'string', 'max:255'],
            'blood_type' => ['required', 'in:' . implode(',', array_column(BloodType::cases(), 'value'))],
            'quantity_ml' => ['required', 'integer', 'min:100'],
            'emergency_level' => ['required', 'in:' . implode(',', array_column(EmergencyLevel::cases(), 'value'))],
            'hospital_details' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
