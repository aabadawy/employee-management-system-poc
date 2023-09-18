<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Job;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory(100)
            ->for(
                Job::query()
                    ->firstOr(
                        fn () => Job::factory()->createOne(['title' => 'software engineer']
                        )
                    )
            )->create();

        Employee::factory(100)
            ->for(
                Job::query()
                    ->firstOr(
                        fn () => Job::factory()->createOne(['title' => 'HR'])
                    )
            )->create();
    }
}
