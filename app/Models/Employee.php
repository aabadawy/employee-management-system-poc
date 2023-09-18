<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'job_id',
        'department_id',
        'mobile_country_code',
        'mobile_number',
        'salary_currency',
        'net_salary',
    ];

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function job(): BelongsTo
    {
        return $this->jobTitle();
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function scopeSearch(Builder $query, string $segment): Builder
    {
        $segment = strtolower("%$segment%");

        return $query
            ->where(DB::raw('LOWER(name)'), 'LIKE', $segment)
            ->orWhereHas('job',
                fn (Builder $q) => $q->where(DB::raw('LOWER(title)'), 'LIKE', $segment)
            );
    }
}
