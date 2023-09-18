<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Testing\Fluent\AssertableJson;

const UPDATE_EMPLOYEE_ENDPOINT = '/api/employees';

describe('updateEmployee', function () {
    it('should update employees passed fields only', function () {
        Employee::factory()->for(
            Job::factory()->createOne()
        )->for(
            Department::factory()->createOne()
        )->createOne([
            'name'  => 'foo ba',
            'net_salary' => 100,
            'salary_currency' => 'usd'
        ]);

        $response = $this->post(UPDATE_EMPLOYEE_ENDPOINT . '/1?_method=PUT', [
            'name' => 'updated name',
            'net_salary'    => 2000,
            'salary_currency' => 'usd',
        ]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->first(function (AssertableJson $json) {
                    $json->where('name','updated name')
                        ->where('net_salary',  2000)
                        ->where('salary_currency','usd')
                        ->etc();
                })
            );

        $response->assertOK();
    });

    it('should return 422 status code when validation failed', function () {

        Employee::factory()->for(
            Job::factory()->createOne()
        )->for(
            Department::factory()->createOne()
        )->createOne([
            'name'  => 'foo ba',
            'net_salary' => 100,
            'salary_currency' => 'usd'
        ]);

        $response = $this->post(UPDATE_EMPLOYEE_ENDPOINT . '/1?_method=PUT', [
            'name' => '',
            'job_id' => null,
            'net_salary' => 4000,
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['name','job_id','salary_currency'],'errors');
    });

    it('should return 404 status code when employee not exist in db', function () {
        $response = $this->post(UPDATE_EMPLOYEE_ENDPOINT . '/1?_method=PUT');

        $response->assertStatus(404);
    });
});
