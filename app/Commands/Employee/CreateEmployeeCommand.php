<?php

namespace App\Commands\Employee;

use App\Data\EmployeeData;
use App\Models\Employee;

class CreateEmployeeCommand
{
    public function execute(EmployeeData $employeeData): Employee
    {
        $employee = new Employee($employeeData->toArray());

        $employee->save();

        return $employee->refresh()->load([
            'job',
            'department',
        ]);
    }
}
