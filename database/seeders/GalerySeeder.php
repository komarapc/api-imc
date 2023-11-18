<?php

namespace Database\Seeders;

use App\Models\Galery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GalerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generic_code_tkit = '001^001';
        $generic_code_sdit = '001^002';
        $generic_code_smpit = '001^003';
        $galeri_tk = [
            [
                'name' => 'Masa Orientasi Orang Tua (MOOT)',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Masa Orientasi Murid (MOM)',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Welcome Back',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Fun Cooking',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Fun Swimming',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Puncak Tema',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Assembly',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Outing Class',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Field Trip',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Home Visit',
                'description' => '',
                'generic_code_id' => $generic_code_tkit
            ],
        ];

        $galeri_sd = [
            [
                'name' => 'Masa Orientasi Orang Tua (MOOT)',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Masa Orientasi Orang Murid (MOM)',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Masa Orientasi Orang Murid (MOM)',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Welcome Back',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kegiatan Islamic Day',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kegiatan Class Meeting',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Projek Penguatan Profil Pelajar Pancasila (P5)',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Fun Swimming',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Assembly',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Outing Class',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Field Trip',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Home Visit',
                'description' => '',
                'generic_code_id' => $generic_code_sdit,
            ],
        ];

        $galeri_smp = [
            [
                'name' => 'Masa Orientasi Orang Tua (MOOT)',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Masa Orientasi Orang Murid (MOM)',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Welcome Back',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Kegiatan Islamic Day',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Pelatihan dan Pelantikan OSIS',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Pelatihan dan Pelantikan OSIS',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Projek Penguatan Profil Pelajar Pancasila (P5)',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'LDKS',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Perkemahan Jumat Sabtu',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Fun Swimming',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Assembly',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Field Trip',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Home Visit',
                'description' => '',
                'generic_code_id' => $generic_code_smpit,
            ],
        ];

        try {
            DB::beginTransaction();
            foreach ($galeri_tk as $tk) {
                Galery::create($tk);
            }
            foreach ($galeri_sd as $sd) {
                Galery::create($sd);
            }
            foreach ($galeri_smp as $smp) {
                Galery::create($smp);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
