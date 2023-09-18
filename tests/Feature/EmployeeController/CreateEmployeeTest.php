<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    Job::factory(10)->create();
    Department::factory(10)->create();
    User::factory()->create();
});

$request_body = [
    'name' => 'foo ba',
    'email' => 'foo@gmail.com',
    'job_id' => 1,
    'department_id' => 1,
    'mobile_number' => 11114470249,
    'mobile_country_code' => '+20',
    'net_salary' => 1500,
    'salary_currency' => 'usd',
];

const CREATE_EMPLOYEE_ENDPOINT = '/api/employees';

describe('createEmployee', function () use ($request_body) {

    it('should create new employee and return Employee Resource', function () use ($request_body) {
        $response = $this->actingAs(User::query()->first())
            ->post(CREATE_EMPLOYEE_ENDPOINT, $request_body);

        $response->assertCreated();

        $response
            ->assertJson(fn (AssertableJson $json) => $json
                ->hasAll([
                    'data.name',
                    'data.email',
                    'data.mobile_country_code',
                    'data.mobile_number',
                    'data.salary_currency',
                    'data.net_salary',
                    'data.job.title',
                    'data.department.name',
                ])
            );

        expect(Employee::query()->count())->toEqual(1);
    });

    it('should throw 422 and show the validation errors when request data not valid', function () use ($request_body) {
        unset($request_body['name']);

        $request_body['net_salary'] = 'should not be string';

        $response = $this->actingAs(User::query()->first())
            ->post(CREATE_EMPLOYEE_ENDPOINT, $request_body);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['name', 'net_salary'], 'errors');
    });
});
