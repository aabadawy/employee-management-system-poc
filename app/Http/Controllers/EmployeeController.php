<?php

namespace App\Http\Controllers;

use App\Commands\Employee\CreateEmployeeCommand;
use App\Commands\Employee\UpdateEmployeeCommand;
use App\Data\EmployeeData;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Queries\Employee\IndexEmployeeQuery;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexEmployeeQuery $query)
    {
        return EmployeeResource::collection(
            $query->paginate(request()->integer('per_page',25))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request,CreateEmployeeCommand $createEmployeeCommand)
    {
        $employee = $createEmployeeCommand->execute(
            EmployeeData::from(
                $request->validated()
            )
        );

        return EmployeeResource::make($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return EmployeeResource::make($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee,UpdateEmployeeCommand $updateEmployeeCommand)
    {
        return EmployeeResource::make(
            $updateEmployeeCommand->execute(
                $employee,
                EmployeeData::from(
                    array_merge(
                        $employee->attributesToArray(),
                        $request->validated(),
                    )
                )
            )
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //todo create deleteEmployeeCommand

        $employee->delete();

        return EmployeeResource::make(
            $employee
        );
    }
}
