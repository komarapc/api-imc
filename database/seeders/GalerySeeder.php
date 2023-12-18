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
                'description' => "Masa Orientasi Orang Tua (MOOT) merupakan momen penting bagi orang tua dan sekolah untuk saling mengenal dan bersinergi dalam mendidik anak. Melalui MOOT, orang tua dapat memahami visi dan misi sekolah, kurikulum yang digunakan, serta program-program pendidikan di SIT imc Palembang. Kegiatan tahunan ini diselenggarakan untuk memperkenalkan lingkungan sekolah dengan mendapatkan berbagai informasi tentang sekolah, mulai dari visi dan misi sekolah, kurikulum yang digunakan, fasilitas yang tersedia, hingga kegiatan ekstrakurikuler. Kegiatan ini bertujuan untuk menyamakan persepsi antara pihak sekolah dan orang tua dalam mendidik anak.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Masa Orientasi Murid (MOM)',
                'description' => "Masa Orientasi Murid (MOM) merupakan kegiatan rutin yang diadakan oleh sekolah-sekolah di Indonesia, khususnya di SIT imc Palembang. MOM biasanya diisi dengan berbagai kegiatan yang menarik dan edukatif. Melalui MOM, cendekia dapat mengenal sekolah, guru-guru, dan teman-teman sekelasnya dengan lebih baik. Hal ini akan memudahkan mereka untuk mengikuti pembelajaran di sekolah dan bersosialisasi dengan lingkungan sekolah.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Welcome Back',
                'description' => "Welcome Back atau hari selamat datang dan kembali ke sekolah merupakan kegiatan yang diadakan untuk menyambut kedatangan cendekia. Tujuan dari welcome day untuk menciptakan suasana yang menyenangkan dan akrab sesama cendekia dan meningkatkan semangat belajar cendekia.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Fun Cooking',
                'description' => "Fun Cooking adalah program yang dirancang untuk memberikan pengalaman memasak yang menyenangkan dan edukatif bagi siswa. Program ini bertujuan untuk meningkatkan keterampilan memasak cendekia dan mengajarkan cendekia tentang pentingnya gizi dan kesehatan. Cendekia akan belajar berbagai macam resep makanan, mulai dari makanan ringan hingga makanan berat. Selain belajar memasak, cendekia juga belajar tentang nilai-nilai penting, seperti kerja sama dan kebersihan. Program ini dapat membantu cendekia untuk tumbuh menjadi pribadi yang mandiri dan bertanggung jawab.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Fun Swimming',
                'description' => "Fun Swimming adalah program olahraga renang yang dirancang khusus untuk cendekia. Program ini bertujuan untuk mengajarkan keterampilan berenang dasar, serta meningkatkan kemampuan fisik, dan mental siswa. Olahraga ini dapat meningkatkan kebugaran fisik, mengurangi stres, dan meningkatkan kepercayaan diri. Fun Swimming cendekia dibimbing oleh pelatih profesional yang berpengalaman dan bersertifikat. Berenang juga dapat menjadi sarana untuk meningkatkan prestasi akademik cendekia.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Puncak Tema',
                'description' => "Puncak tema dilakukan di akhir pembelajaran tematik di TKIT imc Palembang. Kegiatan ini bertujuan untuk menciptakan kegiatan yang lebih bermakna dan menyenangkan bagi cendekia tentang tema yang telah dipelajari. Puncak tema dapat dilakukan dalam berbagai bentuk, seperti permainan edukatif, seni dan kreativitas, dll.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Assembly',
                'description' => "Assembly adalah salah satu kegiatan rutin yang dilakukan sekolah. Kegiatan ini bertujuan untuk melatih disiplin, kemampuan berbicara di depan umum, dan menyalurkan minat bakat cendekia. Kegiatan ini diisi dengan aktivitas yang dapat mengembangkan keterampilan cendekia.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Outing Class',
                'description' => "Outing Class adalah kegiatan yang sangat bermanfaat bagi cendekia. Kegiatan ini bertujuan untuk meningkatkan kualitas belajar cendekia dengan memberikan pengalaman baru, pengetahuan, dan mengembangkan keterampilan cendekia. Cendekia dapat bekerja sama, berkomunikasi, dan memecahkan masalah bersama teman-temannya.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => "Hari Kemerdekaan Republik Indonesia yang jatuh pada tanggal 17 Agustus merupakan momen yang sangat penting bagi bangsa Indonesia. Kemerdakaan sangat penting untuk membangun jiwa kepemimpinan yang tangguh untuk menjadi generasi muda sejak dini. Lomba-lomba yang diadakan dalam rangka Hari Kemerdekaan umumnya bersifat berkelompok. Hal ini bertujuan untuk melatih kerja sama dan kepemimpinan cendekia. Setiap cendekia harus mampu bekerja sama dengan anggota timnya untuk mencapai tujuan bersama. Dengan mengikuti lomba ini, cendekia dapat belajar untuk melatih jiwa kepemimpinan, berpikir kritis, dan berkomunikasi secara efektif.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Field Trip',
                'description' => "Field trip atau perjalanan studi ke luar kelas merupakan salah satu kegiatan pembelajaran yang penting bagi siswa. Kegiatan ini dapat memberikan pengalaman belajar yang lebih bermakna dan menyenangkan bagi siswa. Melalui field trip, siswa dapat belajar secara langsung tentang berbagai hal yang tidak dapat mereka pelajari di dalam kelas. Field trip dapat memberikan berbagai manfaat bagi siswa dengan meningkatkan pemahaman siswa terhadap materi pelajaran, kemampuan siswa untuk memecahkan masalah, dan bekerja sama.",
                'generic_code_id' => $generic_code_tkit
            ],
            [
                'name' => 'Home Visit',
                'description' => "Home visit sekolah adalah kegiatan kunjungan guru ke rumah siswa untuk bertemu dengan orang tua atau wali siswa. Kegiatan ini bertujuan untuk membangun komunikasi dan sinergi antara pihak sekolah dengan orang tua siswa. Home visit sekolah memiliki banyak manfaat, antara lain: 1. Membantu guru untuk memahami kondisi dan latar belakang siswa. 2. Membantu guru untuk memberikan dukungan kepada siswa. 3. Membantu orang tua siswa untuk memahami perkembangan belajar siswa.",
                'generic_code_id' => $generic_code_tkit
            ],
        ];

        $galeri_sd = [
            [
                'name' => 'Masa Orientasi Orang Tua (MOOT)',
                'description' => "Masa Orientasi Orang Tua (MOOT) merupakan momen penting bagi orang tua dan sekolah untuk saling mengenal dan bersinergi dalam mendidik anak. Melalui MOOT, orang tua dapat memahami visi dan misi sekolah, kurikulum yang digunakan, serta program-program pendidikan di SIT imc Palembang. Kegiatan tahunan ini diselenggarakan untuk memperkenalkan lingkungan sekolah dengan mendapatkan berbagai informasi tentang sekolah, mulai dari visi dan misi sekolah, kurikulum yang digunakan, fasilitas yang tersedia, hingga kegiatan ekstrakurikuler. Kegiatan ini bertujuan untuk menyamakan persepsi antara pihak sekolah dan orang tua dalam mendidik anak.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Masa Orientasi Orang Murid (MOM)',
                'description' => "Masa Orientasi Murid (MOM) merupakan kegiatan rutin yang diadakan oleh sekolah-sekolah di Indonesia, khususnya di SIT imc Palembang. MOM biasanya diisi dengan berbagai kegiatan yang menarik dan edukatif. Melalui MOM, cendekia dapat mengenal sekolah, guru-guru, dan teman-teman sekelasnya dengan lebih baik. Hal ini akan memudahkan mereka untuk mengikuti pembelajaran di sekolah dan bersosialisasi dengan lingkungan sekolah.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Welcome Back',
                'description' => "Welcome Back atau hari selamat datang dan kembali ke sekolah merupakan kegiatan yang diadakan untuk menyambut kedatangan cendekia. Tujuan dari welcome day untuk menciptakan suasana yang menyenangkan dan akrab sesama cendekia dan meningkatkan semangat belajar cendekia.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kegiatan Islamic Day',
                'description' => "Islamic Day adalah acara tahunan yang diselenggarakan SIT imc untuk memperingati hari besar Islam. Kegiatan ini bertujuan untuk meningkatkan pemahaman dan penghayatan umat umat Islam terhadap ajaran Islam, serta untuk mempererat tali silaturahmi antar umat Islam.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Kegiatan Class Meeting',
                'description' => "Class Meeting merupakan kegiatan yang sangat bemanfaat. Kegiatan ini biasanya diadakan pada akhir semester atau tahun ajaran. Class Meeting bertujuan untuk mempererat tali silaturahmi antar siswa serta dapat mengembangkan bakat dan kreativitas siswa.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Projek Penguatan Profil Pelajar Pancasila (P5)',
                'description' => "Projek Penguatan Profil Pelajar Pancasila (P5) merupakan kegiatan kokurikuler berbasis projek yang dirancang untuk menguatkan upaya pencapaian kompetensi dan karakter sesuai dengan profil pelajar Pancasila yang disusun berdasarkan Standar Kompetensi Lulusan. Projek P5 merupakan salah satu upaya untuk mewujudkan profil pelajar Pancasila, yaitu pelajar yang beriman dan bertakwa kepada Tuhan Yang Maha Esa, berkebhinekaan global, gotong royong, mandiri, bernalar kritis, dan kreatif.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Fun Swimming',
                'description' => "Fun Swimming adalah program olahraga renang yang dirancang khusus untuk cendekia. Program ini bertujuan untuk mengajarkan keterampilan berenang dasar, serta meningkatkan kemampuan fisik, dan mental siswa. Olahraga ini dapat meningkatkan kebugaran fisik, mengurangi stres, dan meningkatkan kepercayaan diri. Fun Swimming cendekia dibimbing oleh pelatih profesional yang berpengalaman dan bersertifikat. Berenang juga dapat menjadi sarana untuk meningkatkan prestasi akademik cendekia.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Assembly',
                'description' => "Assembly adalah salah satu kegiatan rutin yang dilakukan sekolah. Kegiatan ini bertujuan untuk melatih disiplin, kemampuan berbicara di depan umum, dan menyalurkan minat bakat cendekia. Kegiatan ini diisi dengan aktivitas yang dapat mengembangkan keterampilan cendekia.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Outing Class',
                'description' => "Outing Class adalah kegiatan yang sangat bermanfaat bagi cendekia. Kegiatan ini bertujuan untuk meningkatkan kualitas belajar cendekia dengan memberikan pengalaman baru, pengetahuan, dan mengembangkan keterampilan cendekia. Cendekia dapat bekerja sama, berkomunikasi, dan memecahkan masalah bersama teman-temannya.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => "Hari Kemerdekaan Republik Indonesia yang jatuh pada tanggal 17 Agustus merupakan momen yang sangat penting bagi bangsa Indonesia. Kemerdakaan sangat penting untuk membangun jiwa kepemimpinan yang tangguh untuk menjadi generasi muda sejak dini. Lomba-lomba yang diadakan dalam rangka Hari Kemerdekaan umumnya bersifat berkelompok. Hal ini bertujuan untuk melatih kerja sama dan kepemimpinan cendekia. Setiap cendekia harus mampu bekerja sama dengan anggota timnya untuk mencapai tujuan bersama. Dengan mengikuti lomba ini, cendekia dapat belajar untuk melatih jiwa kepemimpinan, berpikir kritis, dan berkomunikasi secara efektif.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Field Trip',
                'description' => "Field trip atau perjalanan studi ke luar kelas merupakan salah satu kegiatan pembelajaran yang penting bagi siswa. Kegiatan ini dapat memberikan pengalaman belajar yang lebih bermakna dan menyenangkan bagi siswa. Melalui field trip, siswa dapat belajar secara langsung tentang berbagai hal yang tidak dapat mereka pelajari di dalam kelas. Field trip dapat memberikan berbagai manfaat bagi siswa dengan meningkatkan pemahaman siswa terhadap materi pelajaran, kemampuan siswa untuk memecahkan masalah, dan bekerja sama.",
                'generic_code_id' => $generic_code_sdit,
            ],
            [
                'name' => 'Home Visit',
                'description' => "Home visit sekolah adalah kegiatan kunjungan guru ke rumah siswa untuk bertemu dengan orang tua atau wali siswa. Kegiatan ini bertujuan untuk membangun komunikasi dan sinergi antara pihak sekolah dengan orang tua siswa. Home visit sekolah memiliki banyak manfaat, antara lain: 1. Membantu guru untuk memahami kondisi dan latar belakang siswa. 2. Membantu guru untuk memberikan dukungan kepada siswa. 3. Membantu orang tua siswa untuk memahami perkembangan belajar siswa.",
                'generic_code_id' => $generic_code_sdit,
            ],
        ];

        $galeri_smp = [
            [
                'name' => 'Masa Orientasi Orang Tua (MOOT)',
                'description' => "Masa Orientasi Orang Tua (MOOT) merupakan momen penting bagi orang tua dan sekolah untuk saling mengenal dan bersinergi dalam mendidik anak. Melalui MOOT, orang tua dapat memahami visi dan misi sekolah, kurikulum yang digunakan, serta program-program pendidikan di SIT imc Palembang. Kegiatan tahunan ini diselenggarakan untuk memperkenalkan lingkungan sekolah dengan mendapatkan berbagai informasi tentang sekolah, mulai dari visi dan misi sekolah, kurikulum yang digunakan, fasilitas yang tersedia, hingga kegiatan ekstrakurikuler. Kegiatan ini bertujuan untuk menyamakan persepsi antara pihak sekolah dan orang tua dalam mendidik anak",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Masa Orientasi Orang Murid (MOM)',
                'description' => "Masa Orientasi Murid (MOM) merupakan kegiatan rutin yang diadakan oleh sekolah-sekolah di Indonesia, khususnya di SIT imc Palembang. MOM biasanya diisi dengan berbagai kegiatan yang menarik dan edukatif. Melalui MOM, cendekia dapat mengenal sekolah, guru-guru, dan teman-teman sekelasnya dengan lebih baik. Hal ini akan memudahkan mereka untuk mengikuti pembelajaran di sekolah dan bersosialisasi dengan lingkungan sekolah.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Welcome Back',
                'description' => "Welcome Back atau hari selamat datang dan kembali ke sekolah merupakan kegiatan yang diadakan untuk menyambut kedatangan cendekia. Tujuan dari welcome day untuk menciptakan suasana yang menyenangkan dan akrab sesama cendekia dan meningkatkan semangat belajar cendekia.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Outing Class',
                'description' => "Outing Class adalah kegiatan yang sangat bermanfaat bagi cendekia. Kegiatan ini bertujuan untuk meningkatkan kualitas belajar cendekia dengan memberikan pengalaman baru, pengetahuan, dan mengembangkan keterampilan cendekia. Cendekia dapat bekerja sama, berkomunikasi, dan memecahkan masalah bersama teman-temannya.",
                'generic_code_id' => $generic_code_smpit
            ],
            [
                'name' => 'Kegiatan Islamic Day',
                'description' => "Islamic Day adalah acara tahunan yang diselenggarakan SIT imc untuk memperingati hari besar Islam. Kegiatan ini bertujuan untuk meningkatkan pemahaman dan penghayatan umat umat Islam terhadap ajaran Islam, serta untuk mempererat tali silaturahmi antar umat Islam.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Pelatihan dan Pelantikan OSIS',
                'description' => "Organisasi Siswa Intra Sekolah (OSIS) merupakan salah satu organisasi yang ada di sekolah. OSIS berperan penting dalam mengembangkan potensi siswa dan mewujudkan cita-cita sekolah. Pelatihan dan pelantikan OSIS untuk membekali pengurus OSIS yang kompeten dan profesional. Kegiatan ini menjadi kesempatan bagi cendekia untuk belajar dan mengembangkan diri menjadi pemimpin yang berkarakter.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Projek Penguatan Profil Pelajar Pancasila (P5)',
                'description' => "Projek Penguatan Profil Pelajar Pancasila (P5) merupakan kegiatan kokurikuler berbasis projek yang dirancang untuk menguatkan upaya pencapaian kompetensi dan karakter sesuai dengan profil pelajar Pancasila yang disusun berdasarkan Standar Kompetensi Lulusan. Projek P5 merupakan salah satu upaya untuk mewujudkan profil pelajar Pancasila, yaitu pelajar yang beriman dan bertakwa kepada Tuhan Yang Maha Esa, berkebhinekaan global, gotong royong, mandiri, bernalar kritis, dan kreatif.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'LDKS',
                'description' => "Kepemimpinan adalah kemampuan untuk memengaruhi dan mengarahkan untuk mencapai tujuan bersama. Latihan Dasar Kepemimpinan Siswa (LDKS) adalah kegiatan yang bertujuan untuk : - Meningkatkan kesadaran cendekia akan pentingnya kepemimpinan - Membentuk karakter pemimpinan yang tangguh, berkarakter, dan berintegras - Meningkatkan kemampuan siswa dalam memimpin dan mengelola diri sendiri, orang lain, dan lingkungan",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Perkemahan Jumat Sabtu',
                'description' => "Perkemahan Jumat Sabtu merupakan kegiatan perkemahan yang diadakan hari Jumat dan Sabtu. Kegiatan ini bertujuan untuk melatih kemandirian, memiliki jiwa kepemimpinan, dan kerja sama antar cendekia. Selain itu, cendekia belajar menghargai alam dan menunmbuhkan rasa cinta lingkungan. Dengan mengikuti kegiatan ini, cendekia mendapatkan banyak manfaat secara keterampilan, karakter, dan sosial.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Fun Swimming',
                'description' => "Fun Swimming adalah program olahraga renang yang dirancang khusus untuk cendekia. Program ini bertujuan untuk mengajarkan keterampilan berenang dasar, serta meningkatkan kemampuan fisik, dan mental siswa. Olahraga ini dapat meningkatkan kebugaran fisik, mengurangi stres, dan meningkatkan kepercayaan diri. Fun Swimming cendekia dibimbing oleh pelatih profesional yang berpengalaman dan bersertifikat. Berenang juga dapat menjadi sarana untuk meningkatkan prestasi akademik cendekia",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Assembly',
                'description' => "Assembly adalah salah satu kegiatan rutin yang dilakukan sekolah. Kegiatan ini bertujuan untuk melatih disiplin, kemampuan berbicara di depan umum, dan menyalurkan minat bakat cendekia. Kegiatan ini diisi dengan aktivitas yang dapat mengembangkan keterampilan cendekia.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Lomba Hari Kemerdekaan',
                'description' => "Hari Kemerdekaan Republik Indonesia yang jatuh pada tanggal 17 Agustus merupakan momen yang sangat penting bagi bangsa Indonesia. Kemerdakaan sangat penting untuk membangun jiwa kepemimpinan yang tangguh untuk menjadi generasi muda sejak dini. Lomba-lomba yang diadakan dalam rangka Hari Kemerdekaan umumnya bersifat berkelompok. Hal ini bertujuan untuk melatih kerja sama dan kepemimpinan cendekia. Setiap cendekia harus mampu bekerja sama dengan anggota timnya untuk mencapai tujuan bersama. Dengan mengikuti lomba ini, cendekia dapat belajar untuk melatih jiwa kepemimpinan, berpikir kritis, dan berkomunikasi secara efektif.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Field Trip',
                'description' => "Field trip atau perjalanan studi ke luar kelas merupakan salah satu kegiatan pembelajaran yang penting bagi siswa. Kegiatan ini dapat memberikan pengalaman belajar yang lebih bermakna dan menyenangkan bagi siswa. Melalui field trip, siswa dapat belajar secara langsung tentang berbagai hal yang tidak dapat mereka pelajari di dalam kelas. Field trip dapat memberikan berbagai manfaat bagi siswa dengan meningkatkan pemahaman siswa terhadap materi pelajaran, kemampuan siswa untuk memecahkan masalah, dan bekerja sama.",
                'generic_code_id' => $generic_code_smpit,
            ],
            [
                'name' => 'Home Visit',
                'description' => "Home visit sekolah adalah kegiatan kunjungan guru ke rumah siswa untuk bertemu dengan orang tua atau wali siswa. Kegiatan ini bertujuan untuk membangun komunikasi dan sinergi antara pihak sekolah dengan orang tua siswa. Home visit sekolah memiliki banyak manfaat, antara lain: 1. Membantu guru untuk memahami kondisi dan latar belakang siswa. 2. Membantu guru untuk memberikan dukungan kepada siswa. 3. Membantu orang tua siswa untuk memahami perkembangan belajar siswa.",
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
