<?php

namespace Database\Seeders;

use App\Models\GenericCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenericCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GenericCode::create([
            'generic_code_id' => '001',
            'generic_code_name' =>  "Jenjang Pendidikan"
        ]);
        GenericCode::create([
            'generic_code_id' => '001^001',
            'generic_code_name' =>  "TKIT imc",
        ]);
        GenericCode::create([
            'generic_code_id' => '001^002',
            'generic_code_name' =>  "SDIT imc",
        ]);
        GenericCode::create([
            'generic_code_id' => '001^003',
            'generic_code_name' =>  "SMPIT imc",
        ]);
    }
}
