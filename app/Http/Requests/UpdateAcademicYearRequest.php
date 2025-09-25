<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\AcademicYear;

class UpdateAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('academic_year') ?? $this->route('academic-years') ?? $this->route('academicYear') ?? $this->route('id');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('academic_years', 'name')->ignore($id)],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['sometimes', 'boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('academic_year') ?? $this->route('academic-years') ?? $this->route('academicYear') ?? $this->route('id');
            $start = $this->date('start_date');
            $end = $this->date('end_date');
            if ($start && $end) {
                $overlap = AcademicYear::query()
                    ->where('id', '!=', $id)
                    ->where(function ($q) use ($start, $end) {
                        $q->where('start_date', '<=', $end)
                          ->where('end_date', '>=', $start);
                    })
                    ->exists();
                if ($overlap) {
                    $validator->errors()->add('start_date', 'Cette période chevauche une année académique existante.');
                    $validator->errors()->add('end_date', 'Cette période chevauche une année académique existante.');
                }
            }
        });
    }
}
