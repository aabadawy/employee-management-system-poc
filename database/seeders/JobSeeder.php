<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jobs')->delete();

        DB::table('jobs')->insert([
            ['title' => 'software engineer'],
            ['title' => 'HR'],
        ]);
    }
}
