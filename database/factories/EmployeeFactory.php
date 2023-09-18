<?php

namespace Database\Factories;

use App\Enums\Employee\SalaryCurrency;
use App\Enums\Employee\SupportedCountryCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mobile_number' => (int) $this->faker->e164PhoneNumber(),
            'mobile_country_code' => $this->faker->randomElement([SupportedCountryCode::Egypt, SupportedCountryCode::Usa]),
            'net_salary' => $this->faker->randomFloat(2, 1000, 5000),
            'salary_currency' => $this->faker->randomElement([SalaryCurrency::Usd]),
        ];
    }
}
