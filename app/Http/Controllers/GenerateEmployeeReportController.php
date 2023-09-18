<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class GenerateEmployeeReportController extends Controller
{
    public function __invoke()
    {
        //todo generate report as excel using queue job

        //todo create query/command to generate the report
        return EmployeeResource::collection(
            Employee::query()
                ->orderByDesc('department_id')
                ->orderBy('salary_currency')
                ->orderByDesc('net_salary')
                ->orderBy('id')
                //add id as default order to avoid duplicate rows see https://stackoverflow.com/questions/43798247/laravel-pagination-showing-duplicate-and-replacing-random-row
            ->paginate(\request()->integer('per_page',25))
        );
    }
}
