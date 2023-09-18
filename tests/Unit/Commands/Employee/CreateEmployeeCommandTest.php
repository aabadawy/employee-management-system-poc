<?php

use App\Commands\Employee\CreateEmployeeCommand;
use App\Data\EmployeeData;
use App\Enums\Employee\SalaryCurrency;
use App\Enums\Employee\SupportedCountryCode;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('should have execute method', function () {
    expect(CreateEmployeeCommand::class)->toHaveMethod('execute');
});

it('should return created employee', function () {
    $createEmployeeCommand = app(CreateEmployeeCommand::class);

    Job::factory()->createOne();

    Department::factory()->createOne();

    $result = $createEmployeeCommand->execute(
        EmployeeData::from([
            'name' => 'foo ba',
            'email' => 'foo@example.com',
            'mobile_country_code' => SupportedCountryCode::Egypt,
            'mobile_number' => 1114470249,
            'net_salary' => 1200,
            'salary_currency' => SalaryCurrency::Usd,
            'job_id' => Job::query()->first()->getKey(),
            'department_id' => Department::query()->first()->getKey(),
        ])
    );

    expect($result)->toBeInstanceOf(Employee::class);
});
