<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generic_code_tkit = '001^001';
        $generic_code_sdit = '001^002';
        $generic_code_smpit = '001^003';

        $fasilitas_tk = [
            [
                'name' => "Gedung Sekolah dengan Nuansa Islam yang Aman dan refresentatif milik sendiri",
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Lingkungan yang Asri, Aman dan Nyaman',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Ruangan Kelas Ber AC dan dilengkapi perangkat Multi Media',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Lapangan Olahraga Indoor',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Lapangan Parkir Luas dan Aman',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Ruangan Multimedia',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Ruangan Perpustakaan',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Kantin Kejujuran dan Keren',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Media Audio dan Visual',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Kolam Renang',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Musala',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Playground',
                'generic_code_id' => $generic_code_tkit,
            ],
            [
                'name' => 'Antar Jemput Sekolah',
                'generic_code_id' => $generic_code_tkit,
            ],
        ];
        $fasilitas_sd = [
            [
                'name' => "Gedung Sekolah dengan Nuansa Islam yang Aman dan refresentatif milik sendiri",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Lingkungan yang Asri, Aman dan Nyaman',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Ruangan Kelas Ber AC dan dilengkapi perangkat Multi Media',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Lapangan Olahraga Indoor',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Lapangan Parkir Luas dan Aman',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Ruangan Multimedia',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Ruangan Perpustakaan',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Laboratorium IPA',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kantin Kejujuran dan Keren',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Media Audio dan Visual',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kolam Renang',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Musala',
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Antar Jemput Sekolah',
                'generic_code_id' => $generic_code_sdit,
            ],
        ];
        $fasilitas_smp = [
            [
                'name' => "Gedung Sekolah dengan Nuansa Islam yang Aman dan refresentatif milik sendiri",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Lingkungan yang Asri, Aman dan Nyaman',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Ruangan Kelas Ber AC dan dilengkapi perangkat Multi Media',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Lapangan Olahraga Indoor',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Lapangan Parkir Luas dan Aman',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Ruangan Multimedia',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Ruangan Perpustakaan',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Laboratorium IPA',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Kantin Kejujuran dan Keren',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Media Audio dan Visual',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Kolam Renang',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Musala',
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Antar Jemput Sekolah',
                'generic_code_id' => $generic_code_smpit,
            ],
        ];

        try {
            DB::beginTransaction();
            foreach ($fasilitas_tk as $fasilitas) {
                Fasilitas::create($fasilitas);
            }
            foreach ($fasilitas_sd as $fasilitas) {
                Fasilitas::create($fasilitas);
            }
            foreach ($fasilitas_smp as $fasilitas) {
                Fasilitas::create($fasilitas);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
