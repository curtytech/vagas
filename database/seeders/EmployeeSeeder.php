<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $employeeUsers = DB::table('users')
            ->where('role', 'employee')
            ->orderBy('id')
            ->limit(2)
            ->get();

        DB::table('employees')->insert([
            [
                'user_id' => $employeeUsers[0]->id,
                'phone' => '+55 11 91234-5678',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'resume_path' => null,
                'linkedin_url' => 'https://www.linkedin.com/in/alice-candidate',
                'portfolio_url' => null,
                'summary' => 'Dev backend júnior com interesse em PHP/Laravel.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $employeeUsers[1]->id,
                'phone' => '+55 21 99876-5432',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'country' => 'Brasil',
                'resume_path' => null,
                'linkedin_url' => 'https://www.linkedin.com/in/bruno-candidate',
                'portfolio_url' => null,
                'summary' => 'Designer UI/UX com foco em produtos digitais.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}