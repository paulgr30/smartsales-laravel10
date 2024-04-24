<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create([
            'ruc'           => '00000000000',
            'name_business' => 'Mi Negocio',
            'address'       => 'Mi direccion',
            'phone'         => '000000000',
            'email'         => 'admin@minegocio.com',
            'sales_tax'     => '18',
            'image_url'     => 'logo.png',
        ]);
    }
}
