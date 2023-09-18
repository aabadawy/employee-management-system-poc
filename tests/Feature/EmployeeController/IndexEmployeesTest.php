<?php

use App\Models\Employee;
use App\Models\Job;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    Employee::factory(100)->for(
        Job::factory()->createOne(['title' => 'any job title']),'jobTitle'
    )->create();
});
const INDEX_EMPLOYEE_ENDPOINT = '/api/employees';

describe('indexEmployee',function () {
    it('should return paginated employees with the default pagination number', function () {
        $default_paginate_number = 25;

        $response = $this->get(INDEX_EMPLOYEE_ENDPOINT);

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->hasAll([
                    'data',
                    'links',
                    'meta'
                ])
            );

        $response->assertJsonCount($default_paginate_number,'data');

        $response->assertOk();
    });

    it('should return only employees where with search criteria for name or job title', function () {
        Employee::factory(5)->for(
            Job::factory()->createOne(['title' => 'software engineer'])
        )->create();

        Employee::factory(5)->for(
            Job::factory()->createOne(['title' => 'hr'])
        )->create([
            'name' => 'software engineer'
        ]);

        $response = $this->get(INDEX_EMPLOYEE_ENDPOINT . '?filter[search]=software engineer');

        $response
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->hasAll([
                    'data',
                    'links',
                    'meta'
                ])
            );

        $response->assertJsonCount(10,'data');

        $response->assertOk();
    });

    it('should return 400 status code when pass not allowed filter key', function () {

        $response = $this->get(INDEX_EMPLOYEE_ENDPOINT . '?filter[unknown_filter_key]=software engineer');

        $response->assertStatus(400);
    });
});
