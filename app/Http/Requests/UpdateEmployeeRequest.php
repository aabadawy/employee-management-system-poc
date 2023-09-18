<?php

namespace App\Http\Requests;

use App\Enums\Employee\SalaryCurrency;
use App\Enums\Employee\SupportedCountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['filled', 'string', 'min:3', 'max:200'],
            'email' => ['filled', 'string', 'email', 'max:300'],
            'job_id' => ['filled', 'integer', Rule::exists('jobs', 'id')],
            'department_id' => ['filled', 'integer', Rule::exists('departments', 'id')],
            'mobile_country_code' => ['required_with:mobile_number', Rule::enum(SupportedCountryCode::class)],
            'mobile_number' => ['required_with:mobile_country_code', 'integer'], //todo validate mobile number with the country code
            'salary_currency' => ['required_with:net_salary', Rule::enum(SalaryCurrency::class)],
            'net_salary' => ['required_with:salary_currency', 'numeric', 'min:1', 'max:1000000000'],
        ];
    }
}
