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
        $jenjang = [
            [
                'generic_code_id' => '001',
                'generic_code_name' =>  "Jenjang Pendidikan"
            ],
            [
                'generic_code_id' => '001^001',
                'generic_code_name' =>  "TKIT imc",
            ],
            [
                'generic_code_id' => '001^002',
                'generic_code_name' =>  "SDIT imc",
            ],
            [
                'generic_code_id' => '001^003',
                'generic_code_name' =>  "SMPIT imc",
            ],
            [
                'generic_code_id' => '001^004',
                'generic_code_name' =>  "Yayasan imc",
            ],
        ];
        foreach ($jenjang as $value) {
            GenericCode::create($value);
        }
        $article = [
            [
                'generic_code_id' => '002',
                'generic_code_name' =>  "Berita Artikel dan Info"
            ],
            [
                'generic_code_id' => '002^001',
                'generic_code_name' =>  "Berita dan Artikel"
            ],
            [
                'generic_code_id' => '002^002',
                'generic_code_name' =>  "Info dan Event"
            ],
        ];
        foreach ($article as $value) {
            GenericCode::create($value);
        }
        $post_status = [
            [
                'generic_code_id' => '003',
                'generic_code_name' =>  "Status Postingan"
            ],
            [
                'generic_code_id' => '003^001',
                'generic_code_name' =>  "Draft"
            ],
            [
                'generic_code_id' => '003^002',
                'generic_code_name' =>  "Publish"
            ],
        ];
        foreach ($post_status as $value) {
            GenericCode::create($value);
        }
    }
}
