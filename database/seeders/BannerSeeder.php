<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title' => 'Membangun Generasi Cerdas dan Bertakwa',
            'description' => 'Masa depan adalah masa yang penuh tantangan dan akan mengalami perubahan tatanan yang sangat cepat . Untuk itu, diperlukan persiapan sumber daya manusia berkualitas dan punya wawasan luas untuk membangun NKRI yang kita cintai. Sumber daya manusia yang kuat dan berkualitas harus dapat dipersiapkan dengan baik agar mempunyai kemampuan atau kompetensi memimpin, baik memimpin dari skala kecil yaitu memimpin dirinya sendiri maupun memimpin kelompok di skala kecil maupun skala besar',
            'video_url' => 'https://www.youtube.com/embed/X5ZsboKyMLw',

        ]);
    }
}
