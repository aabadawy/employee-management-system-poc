<?php

namespace App\Data;

use App\Enums\Employee\SalaryCurrency;
use App\Enums\Employee\SupportedCountryCode;
use Spatie\LaravelData\Data;

class EmployeeData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public int $job_id,
        public SupportedCountryCode $mobile_country_code,
        public int $mobile_number,
        public SalaryCurrency $salary_currency,
        public float $net_salary
    ) {}
}
