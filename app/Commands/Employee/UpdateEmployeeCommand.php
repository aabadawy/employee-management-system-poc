<?php

namespace App\Commands\Employee;

use App\Data\EmployeeData;
use App\Models\Employee;

class UpdateEmployeeCommand
{

    public function execute(Employee $employee,EmployeeData $employeeData):Employee
    {
        $employee->update(
            $employeeData->toArray()
        );

        return $employee->refresh()->load([
            'jobTitle'
        ]);
    }
}
