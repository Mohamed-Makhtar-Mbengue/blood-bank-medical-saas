<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBloodInventoryRequest extends FormRequest
{
    public function authorize(){
        return true;
    }
    public function rules()
    {
        return [
            'blood_type'      => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'quantity_ml'     => 'required|integer|min:50',
            'expiration_date' => 'required|date|after:today',
            'donation_id'     => 'nullable|exists:donations,id',
        ];
    }
}
