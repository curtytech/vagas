<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            [
                'name' => 'Alice Candidate',
                'email' => 'alice.candidate@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Bruno Candidate',
                'email' => 'bruno.candidate@example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Acme Owner',
                'email' => 'owner@acme.example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('12345678'),
                'role' => 'enterprise',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Globex Owner',
                'email' => 'owner@globex.example.com',
                'email_verified_at' => $now,
                'password' => Hash::make('12345678'),
                'role' => 'enterprise',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}