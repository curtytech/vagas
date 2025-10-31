<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobListingSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $enterprise = DB::table('enterprises')->orderBy('id')->first();

        DB::table('job_listings')->insert([
            [
                'enterprise_id' => $enterprise->id,
                'title' => 'Desenvolvedor Backend (PHP/Laravel)',
                'slug' => 'desenvolvedor-backend-php-laravel',
                'description' => 'Atuação em APIs REST, queues e integrações.',
                'location' => 'São Paulo, SP',
                'is_remote' => true,
                'employment_type' => 'full_time',
                'salary_min' => 6000.00,
                'salary_max' => 9000.00,
                'status' => 'published',
                'published_at' => $now,
                'expires_at' => null,
                'apply_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'enterprise_id' => $enterprise->id,
                'title' => 'Designer UI/UX',
                'slug' => 'designer-ui-ux',
                'description' => 'Criação de interfaces e fluxos de usuário.',
                'location' => 'Remoto',
                'is_remote' => true,
                'employment_type' => 'contract',
                'salary_min' => 4000.00,
                'salary_max' => 7000.00,
                'status' => 'published',
                'published_at' => $now,
                'expires_at' => null,
                'apply_url' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}