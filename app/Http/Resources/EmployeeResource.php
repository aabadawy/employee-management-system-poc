<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => (int) $this->getKey(),
            'name'  => (string) $this->name,
            'email'  => (string) $this->email,
            'mobile_country_code'   => (string) $this->mobile_country_code,
            'mobile_number' => (int) $this->mobile_number,
            'salary_currency'   => (string) $this->salary_currency,
            'net_salary'        => (float) $this->net_salary
        ];
    }
}
