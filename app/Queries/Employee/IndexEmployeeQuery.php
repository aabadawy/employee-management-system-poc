<?php

namespace App\Queries\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class IndexEmployeeQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $subject = Employee::query();

        parent::__construct($subject, $request);

        $this->allowedFilters([
            AllowedFilter::scope('search'),
        ]);
    }
}
