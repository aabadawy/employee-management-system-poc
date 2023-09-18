<?php

use App\Enums\Employee\SalaryCurrency;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Testing\Fluent\AssertableJson;

describe('GenerateEmployeesReport', function () {
    it('should return employees sorted DESC by department and salary', function () {
        Employee::factory(2)->for(
            Department::factory()->createOne()
        )->create(['net_salary' => 1000,'salary_currency' => SalaryCurrency::Usd->value]);

        Employee::factory(2)->for(
            Department::factory()->createOne()
        )->create(['net_salary' => 500,'salary_currency' => SalaryCurrency::Egp->value]);

        $response = $this->get('/api/employees-report');

        $response->assertJsonPath('data.*.id',[3,4,1,2]);

        $response->assertJsonPath('data.*.net_salary',[500,500,1000,1000])
            ->assertJsonPath('data.*.salary_currency',['egp','egp','usd','usd']);
    });
});
