<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'healthcare_professional_id' => ['required', 'integer', 'exists:healthcare_professionals,id'],
            'appointment_start_time' => ['required', 'date', 'after:now'],
            'appointment_end_time' => ['required', 'date', 'after:appointment_start_time'],
        ];
    }
}
