<?php

namespace Database\Seeders;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OurTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data_our_teams = [
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Alimin Bassi, S.E., M.Si.',
                    'quote' => "Pemimpin yang berhasil adalah mereka yang mampu melahirkan pemimpin dalam kepemimpinannya"
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Alimuddin, S.Pd., M.Si.',
                    'quote' => "Setiap manusia dilahirkan untuk menjadi pemimpin, dan akan diminta pertanggungjawaban atas kepemimpinanNya. Mari kita siapkan Pemimpin pemimpin masa depan yg amanah, sidik,tabligh dan Fathonah. Sesuai dengan sifat kepemkmpjnan Rosullah Muhammad SAW."
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Sri Suprapti, Amd.',
                    'quote' => "Target utama orang-orang sukses adalah membahagiakan orang tua mereka di masa depan."
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Prof. Drs. H. Dedi Rohendi, M.T., Ph.D.',
                    'quote' => "Jangan bermain-main dengan waktu, karena waktu tidak pernah mau menunggu"
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Drs. H. I Gede Mendera, M.T.',
                    'quote' => "Semakin gelap tempat yang kita datangi, maka semakin berarti cahaya yang kita bawa"
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Al Ustadz Fajar Sani Nasution Al-Hafidz',
                    'quote' => "Pemimpin Qurani adalah sosok yang mengilhami dengan keadilan, bijaksana, dan pemahaman mendalam akan prinsip-prinsip Al-Quran. Mereka membimbing umat dengan tulus dan membawa kedamaian serta kemajuan kepada seluruh manusia."
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Dr. Drs. H. Muslimin Tendri, M.Pd.',
                    'quote' => "Ilmu lebih utama dari harta, karena ilmu warisan para nabi dan rasul, sedangkan harta warisan Qorun, Firaun, dan lainnya. Ilmu menjaga kamu sedangkan harta kamulah yang menjaganya"
                ],
                (object)[
                    'id' => (new Client())->generateId(),
                    'name' => 'Sunandar Tendri, S.Pd., M.Si.',
                    'quote' => "Cara terbaik memprediksi masa depan adalah menciptakannya. imc dengan The School Of Leader akan menciptakan generasi terbaik (pemimpin) masa depan"
                ],
            ];

            DB::beginTransaction();
            foreach ($data_our_teams as $data_our_team) {
                DB::table('our_teams')->insert([
                    'id' => $data_our_team->id,
                    'name' => $data_our_team->name,
                    'quote' => $data_our_team->quote,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
