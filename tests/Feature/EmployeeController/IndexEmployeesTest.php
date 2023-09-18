<?php

use App\Models\Employee;
use App\Models\Job;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    Employee::factory(100)->for(
        Job::factory()->createOne(),'jobTitle'
    )->create();
});

describe('indexEmployee',function () {
    it('should return paginated employees with the default pagination number', function () {
        $default_paginate_number = 25;

        $response = $this->get('/api/employees');

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
});
