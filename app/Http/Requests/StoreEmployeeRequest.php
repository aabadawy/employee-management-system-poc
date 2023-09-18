<?php

namespace App\Http\Requests;

use App\Enums\Employee\SalaryCurrency;
use App\Enums\Employee\SupportedCountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required','string','min:3','max:200'],
            'email' => ['required','string','email','max:300'],
            'job_id'    => ['required','integer',Rule::exists('jobs','id')],
            'department_id'    => ['required','integer',Rule::exists('departments','id')],
            'mobile_country_code' => ['required',Rule::enum(SupportedCountryCode::class)],
            'mobile_number'     => ['required','integer'], //todo validate mobile number with the country code
            'salary_currency'    => ['required',Rule::enum(SalaryCurrency::class)],
            'net_salary' => ['required','numeric','min:1','max:1000000000'],
        ];
    }
}
