<?php

use App\Models\Employee;
use App\Models\Job;

it('should throw 404 when employee not exist in DB', function () {
   $response = $this->get('/api/employees/1');

    $response->assertNotFound($response);
});


it('should return employee', function () {
    $employee = Employee::factory()->for(
        Job::factory()->createOne(),'jobTitle'
    )->createOne();


    $response = $this->get('/api/employees/'.$employee->getKey());

    $response->assertOk();
});
