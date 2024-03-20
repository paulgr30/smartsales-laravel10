<?php

namespace Database\Seeders;

use App\Models\IdentityDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentityDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IdentityDocument::create([
            'name'          => 'Dni',
            'description'   => 'Documento Nacional de Identidad',
            'is_active'     => 1,
        ]);
    }
}
