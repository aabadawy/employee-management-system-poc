<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'job_id',
        'mobile_country_code',
        'mobile_number',
        'salary_currency',
        'net_salary',
    ];

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function job(): BelongsTo
    {
        return $this->jobTitle();
    }
}
