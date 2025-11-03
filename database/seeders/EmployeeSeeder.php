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
            ->limit(4) // aumente para 3 para corresponder aos 3 registros abaixo
            ->get();

        DB::table('employees')->insert([
            [
                'user_id' => $employeeUsers[0]->id,
                'phone' => '+55 11 91234-5678',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'function' => 'Desenvolvedor Backend',
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
                'function' => 'Designer',
                'linkedin_url' => 'https://www.linkedin.com/in/bruno-candidate',
                'portfolio_url' => null,
                'summary' => 'Designer UI/UX com foco em produtos digitais.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $employeeUsers[2]->id,
                'phone' => '+55 21 99999-9999',
                'city' => 'Magé',
                'state' => 'RJ',
                'country' => 'Brasil',
                'function' => 'Desenvolvedor',
                'linkedin_url' => 'https://www.linkedin.com/in/phelipecurty',
                'portfolio_url' => null,
                'summary' => 'Desenvolvedor.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}