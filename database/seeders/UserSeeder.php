<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'                  => 'Paul Garcia',
            'email'                 => 'admin@admin.com',
            'email_verified_at'     => now(),
            'username'              => '12345678',
            'password'              => '12345678',
        ])->assignRole('Admin');

        $user->profile()->create([
            'identity_document_id'  => 1,
            'number_id'             => '12345678',
            'address'               => 'Piura',
            'phone'                 => '000000'
        ]);
    }
}
