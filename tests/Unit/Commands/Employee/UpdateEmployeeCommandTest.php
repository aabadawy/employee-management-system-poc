<?php

use App\Commands\Employee\UpdateEmployeeCommand;
use App\Data\EmployeeData;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('updateEmployeeCommand', function () {
    it('should have execute method', function () {
        expect(UpdateEmployeeCommand::class)->toHaveMethod('execute');
    });

    it('should return employee instance after updated it', function () {
        $employeeBeforeUpdate = Employee::factory()->for(
            Job::factory()->createOne()
        )->for(
            Department::factory()->createOne()
        )->createOne([
            'name' => 'foo ba',
            'net_salary' => 100,
            'salary_currency' => 'usd',
        ]);

        $updateEmployeeCommand = app(UpdateEmployeeCommand::class);

        $toBeUpdatedFields = [
            'name' => 'updated name',
        ];

        $updatedEmployee = $updateEmployeeCommand->execute($employeeBeforeUpdate, EmployeeData::from(
            array_merge($employeeBeforeUpdate->toArray(), $toBeUpdatedFields)
        ));

        expect($updatedEmployee)->toBeInstanceOf(Employee::class);

        expect($updatedEmployee->name)->toEqual('updated name');
    });

    it('should load employee job and department relation after update', function () {
        $employeeBeforeUpdate = Employee::factory()->for(
            Job::factory()->createOne()
        )->for(
            Department::factory()->createOne()
        )->createOne([
            'name' => 'foo ba',
            'net_salary' => 100,
            'salary_currency' => 'usd',
        ]);

        $updateEmployeeCommand = app(UpdateEmployeeCommand::class);

        $updatedEmployee = $updateEmployeeCommand->execute($employeeBeforeUpdate, EmployeeData::from(
            $employeeBeforeUpdate
        ));

        expect($updatedEmployee->relationLoaded('job'))->toBeTrue();

        expect($updatedEmployee->relationLoaded('department'))->toBeTrue();
    });
});
