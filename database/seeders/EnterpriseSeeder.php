<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnterpriseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $enterpriseUsers = DB::table('users')
            ->where('role', 'enterprise')
            ->orderBy('id')
            ->limit(2)
            ->get();

        DB::table('enterprises')->insert([
            [
                'user_id' => $enterpriseUsers[0]->id,
                'company_name' => 'Acme Co',
                'company_slug' => 'acme-co',
                'website_url' => 'https://acme.example.com',
                'contact_email' => $enterpriseUsers[0]->email,
                'contact_phone' => '+55 11 4000-1000',
                'about' => 'Empresa de tecnologia com foco em soluções SaaS.',
                'logo_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $enterpriseUsers[1]->id,
                'company_name' => 'Globex Corp',
                'company_slug' => 'globex-corp',
                'website_url' => 'https://globex.example.com',
                'contact_email' => $enterpriseUsers[1]->email,
                'contact_phone' => '+55 21 4000-2000',
                'about' => 'Consultoria e produtos digitais.',
                'logo_path' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}