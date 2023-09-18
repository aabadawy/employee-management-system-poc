<?php

use App\Models\Employee;
use Illuminate\Testing\Fluent\AssertableJson;

const DELETE_EMPLOYEE_ENDPOINT = '/api/employees';

describe('DeleteEmployee', function () {

    it('should delete employee when employee id valid', function () {

        $employee = Employee::factory()->createOne();

        $response = $this->post(DELETE_EMPLOYEE_ENDPOINT.'/1?_method=DELETE');

        $response->assertOk();

        expect(Employee::query()->whereKey($employee->getKey())->first())->toBeNull();
    });

    it('should return employee instance with deleted_at value', function () {

        Employee::factory()->createOne();

        $response = $this->post(DELETE_EMPLOYEE_ENDPOINT.'/1?_method=DELETE');

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) => $json->whereType('data.deleted_at', 'string')
            ->where('data.deleted_at', Employee::withTrashed()->first()->deleted_at->format('Y-m-d- h:m'))
        );
    });

    it('should return 404 when employee id not exists', function () {
        $response = $this->post(DELETE_EMPLOYEE_ENDPOINT.'/1?_method=DELETE');

        $response->assertStatus(404);
    });

    it('should not found employee when already deleted before', function () {

        $employee = Employee::factory()->createOne();

        $employee->delete();

        $response = $this->post(DELETE_EMPLOYEE_ENDPOINT.'/1?_method=DELETE');

        $response->assertStatus(404);
    });
});
