<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $employees = DB::table('employees')->orderBy('id')->limit(2)->get();
        $jobs = DB::table('job_listings')->orderBy('id')->limit(2)->get();

        DB::table('job_applications')->insert([
            [
                'job_listing_id' => $jobs[0]->id,
                'employee_id' => $employees[0]->id,
                'status' => 'applied',
                'cover_letter' => 'Tenho experiência com Laravel e filas.',
                'resume_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'job_listing_id' => $jobs[1]->id,
                'employee_id' => $employees[1]->id,
                'status' => 'applied',
                'cover_letter' => 'Portfolio com projetos de UI acessíveis.',
                'resume_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}