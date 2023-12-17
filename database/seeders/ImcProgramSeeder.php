<?php

namespace Database\Seeders;

use Hidehalo\Nanoid\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImcProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program_imc = [
            (object)[
                'name' => 'PROGRAM imc AL ISLAM',
                'description' => "Program imc Al Islam adalah program yang memberikan stimulus nilai -nilai keislaman kepada peserta didik, yang bertujuan untuk membentuk Karakter Kepribadian Islam. Kegiatan yang masuk dalam program imc Al Islam adalah kegiatan Tahsin dan Tahfidz serta karantina Tahfidz, Islamic Character Building (ICB), Islamic Day dan Pembiasaan Islam.",
                'sub_program' => [
                    (object)[
                        'name' => 'Dzikir dan Shalawat',
                        'description' => 'Kegiatan dzikir dan shalawat siswa di imc merupakan salah satu kegiatan untuk menanamkan nilai-nilai Islam kepada para siswa. Kegiatan ini juga bertujuan untuk meningkatkan keimanan dan ketakwaan siswa kepada Allah SWT, membina akhlak mulia siswa, menciptakan suasana sekolah yang islami, menenangkan hati dan pikiran siswa serta meningkatkan prestasi belajar siswa.',
                    ],
                    (object) [
                        'name' => 'Islamic Day',
                        'description' => "kegiatan peringatan hari besar Islam di sekolah adalah kegiatan yang dilakukan untuk memperingati hari-hari besar Islam, seperti Maulid Nabi, Isra' Mi'raj, Tahun Baru Islam dan Kegiatan Islam lainnya. Kegiatan peringatan hari besar Islam di imc merupakan salah satu upaya untuk meningkatkan pemahaman dan penghayatan serta nilai-nilai keislaman siswa terhadap ajaran Islam. Dengan adanya kegiatan ini, diharapkan siswa dapat menjadi generasi yang mencintai dan bangga terhadap agama Islam, serta dapat mengamalkan ajaran Islam dalam kehidupan sehari-hari."
                    ],
                    (object) [
                        'name' => 'Kegiatan icb',
                        'description' => "Islamic Character Building adalah kegiatan yang bertujuan untuk menanamkan nilai-nilai karakter Islam kepada siswa di sekolah. Nilai-nilai karakter Islam tersebut meliputi iman, taqwa, akhlak mulia, dan patriotisme"
                    ],
                    (object) [
                        'name' => 'Kegiatan Tahsin dan Tahfidz',
                        'description' => "Tahsin dan tahfidz merupakan kegiatan Unggulan dan sangat penting untuk diajarkan di imc. Tahsin dan tahfidz merupakan dua kegiatan yang saling berkaitan dalam upaya untuk mendalami Al-Qur'an. Tahsin adalah kegiatan untuk memperbaiki bacaan Al-Qur'an sesuai dengan makhraj dan tajwid, sedangkan tahfidz adalah kegiatan untuk menghafal ayat-ayat Al-Qur'an. Tujuan kegiatan tahsin dan tahfidz di imc untuk meningkatkan kemampuan siswa dalam membaca Al-Qur'an dengan tartil dan fasih, membiasakan siswa untuk membaca Al-Qur'an secara rutin dan menanamkan kecintaan siswa terhadap Al-Qur'an."
                    ],
                    (object) [
                        'name' => 'Pembiasaan Islam',
                        'description' => 'Kegiatan pembiasaan Islami di imc adalah kegiatan yang dilakukan secara rutin, berulang-ulang, dan terjadwal untuk menanamkan nilai-nilai Islam dalam diri siswa. Berupa kegiatan keagamaan, seperti murojaah/mengulang dan menambah hafalan, sholat dhuha, Dzikir bersama, shalat berjamaah, memberikan nasehat, dan kegiatannya lainnya.'
                    ],
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc CLEANS',
                'description' => "Program imc Cleans adalah program yang memberikan stimulus untuk hidup bersih kepada peserta didik. Kebersihan diterapkan di seluruh aktifitas imc dimulai dari kedatangan di sekolah sampai dengan kepulangan peserta didik, dari ruang kelas sampai dengan ruang sekolah. kebersihan adalah sebuah simbol keislaman yang harus menjadi pembiasaan di dalam lingkungan imc.",
                'sub_program' => [
                    (object)[
                        'name' => 'Kebersihan Diri',
                        'description' => 'Kebersihan diri siswa di imc adalah keadaan bersih siswa yang meliputi tubuh baik dari rambut, kuku dan anggota tubuh lainnya, kemudian pakaian dan penampilan , dan siswa di sekolah. Kebersihan diri siswa di sekolah penting untuk menjaga kesehatan dan kenyamanan siswa selama belajar di sekolah.'
                    ],
                    (object)[
                        'name' => 'Kebersihan Kelas',
                        'description' => "Kebersihan kelas merupakan hal yang penting untuk dijaga karena Kelas yang bersih dan rapi merupakan impian setiap siswa dan guru. Kelas yang bersih akan membuat siswa merasa lebih nyaman dan betah belajar. Selain itu, kelas yang bersih juga akan membantu menjaga kesehatan siswa dan guru. Untuk menjaga kebersihan kelas, setiap siswa dan guru harus memiliki kesadaran dan tanggung jawab untuk menjaga kebersihan kelasnya. Siswa dan guru dapat melakukan kerja bakti secara rutin untuk membersihkan kelas. Selain itu, siswa dan guru juga harus membiasakan diri untuk membuang sampah pada tempatnya. Dengan menjaga kebersihan kelas, siswa dan guru dapat menciptakan lingkungan belajar yang sehat dan nyaman. Lingkungan belajar yang sehat dan nyaman akan mendukung proses belajar mengajar yang lebih efektif dan efisien."
                    ],
                    (object)[
                        'name' => 'Kebersihan Sekolah',
                        'description' => 'Kebersihan sekolah adalah kondisi lingkungan sekolah yang terbebas dari kotoran, sampah, dan penyakit. Lingkungan sekolah yang bersih akan menciptakan suasana yang nyaman dan sehat bagi warga sekolah, sehingga dapat meningkatkan kualitas pembelajaran. Adapun tujuan kebersihan sekolah adalah menciptakan lingkungan sekolah yang nyaman dan sehat, meningkatkan kualitas pembelajaran, menumbuhkan rasa tanggung jawab warga sekolah terhadap kebersihan dan mencegah penyebaran penyakit.'
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc FUN',
                'description' => "Program imc Fun adalah program yang memberikan stimulus nilai nilai kebahagiaan kepada peserta didik, dimulai dari penyambutan dan pengantaran siswa dilakukan dengan ramah, ceria dan penuh cinta dan kasih sayang, serta kegiatan – kegiatan yang menimbulkan kebahagiaan.",
                'sub_program' => [
                    (object)[
                        'name' => 'Welcome Back Day',
                        'description' => "Penyambutan siswa oleh guru di pagi hari sangat penting. Hal ini dapat memberikan motivasi kepada siswa untuk belajar dengan giat dan semangat. Para guru juga dapat memberikan bantuan kepada siswa jika ada yang tidak mereka pahami. Hal ini dapat membuat siswa merasa nyaman, aman dan menyenangkan di sekolah. Penyambutan siswa oleh guru juga dapat menciptakan suasana yang positif di sekolah. Siswa akan merasa senang dan bersemangat untuk belajar di sekolah. Hal ini dapat meningkatkan prestasi belajar siswa"
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc PEDULI',
                'description' => "Program imc Peduli adalah program yang memberikan stimulus nilai – nilai kebahagiaan, dengan kegiatan donasi siswa yang dilakukan di bulan suci Ramadhan, Idul Qurban serta aktifitas infaq mingguan oleh siswa dan dengan memberikan serta membagikan donasi kepada fakir miskin dan pondok yatim piatu memberikan nilai - nilai kebahagiaan tersendiri kepada peserta didik imc.",
                'sub_program' => [
                    (object)[
                        'name' => 'Adiwiyata',
                        'description' => "Adiwiyata merupakan program yang sangat penting untuk diterapkan di sekolah. Program ini dapat membantu mewujudkan sekolah yang peduli dan berbudaya lingkungan, sehingga dapat meningkatkan kualitas pendidikan dan pembelajaran, serta meningkatkan kesadaran warga sekolah akan pentingnya pelestarian lingkungan. Tujuan Adiwiyata untuk menciptakan lingkungan sekolah yang bersih, sehat, indah, dan nyaman bagi warga sekolah, menumbuhkan kesadaran warga sekolah akan pentingnya pelestarian lingkungan, menjadikan sekolah sebagai laboratorium pembelajaran dan pengabdian masyarakat dalam bidang lingkungan hidup"
                    ],
                    (object)[
                        'name' => 'Donasi',
                        'description' => "Kegiatan donasi di sekolah adalah kegiatan yang dilakukan oleh siswa, guru, dan orang tua murid untuk mengumpulkan dana atau barang untuk membantu orang lain atau suatu tujuan tertentu. Kegiatan donasi di sekolah dapat menjadi sarana untuk belajar peduli terhadap sesama dan lingkungan sekitar."
                    ],
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc TERSENYUM',
                'description' => "Program imc Tersenyum juga adalah program yang memberikan stimulus nilai-nilai kebahagiaan, ditetapkan setiap tanggal 07 dan 21 setiap bulannya. Seluruh civitas akademik imc diwajibkan untuk melaksanakan seluruh aktivitas dengan senyuman. SENYUMAN ADALAH GERBANG PINTU UNTUK MENUJU KESUKSESAN.",
                'sub_program' => [
                    (object)[
                        'name' => 'Hari Tersenyum',
                        'description' => "Hari Tersenyum di imc adalah kegiatan yang dilakukan oleh seluruh warga sekolah untuk saling berbagi senyuman. Kegiatan ini bertujuan untuk menciptakan suasana sekolah yang lebih positif dan menyenangkan, meningkatkan rasa saling menghargai dan menghormati, membangun rasa kebersamaan dan kekeluargaan serta meningkatkan motivasi belajar siswa. Hari Tersenyum di imc adalah kegiatan sederhana yang dapat berdampak besar. Dengan tersenyum, kita dapat membuat dunia menjadi tempat yang lebih baik."
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc SMART',
                'description' => "Program imc Smart adalah program yang memberikan stimulus nilai – nilai kecerdasan, dengan kegiatan literasi numerasi dan pembiasaan membaca buku sesuai dengan bakat kecerdasan yang dimiliki para peserta didik serta science project dan dengan Kecerdasan serta bakat yang dimiliki oleh siswa ditumbuhkembangkan melalui strategi pembelajaran khas di imc, diharapkan siswa akan mempunyai kecerdasan sesuai dengan Bakat dan Kecerdasan yang dimiliki",
                'sub_program' => [
                    (object)[
                        'name' => 'Literasi Numerasi',
                        'description' => "Literasi dan numerasi adalah dua keterampilan yang sangat penting bagi siswa di imc. Kegiatan literasi dan numerasi di imc bertujuan untuk meningkatkan kemampuan siswa dalam membaca, menulis, dan memahami informasi tertulis, serta menggunakan angka dan simbol matematika untuk memecahkan masalah. Kegiatan ini memiliki banyak manfaat bagi siswa, antara lain meningkatkan kemampuan siswa dalam membaca, menulis, dan memahami informasi tertulis; meningkatkan kemampuan siswa dalam menggunakan angka dan simbol matematika untuk memecahkan masalah; meningkatkan pengetahuan dan wawasan siswa; meningkatkan kreativitas dan daya imajinasi siswa; meningkatkan kemampuan siswa untuk berpikir kritis dan analitis; serta meningkatkan kemampuan siswa untuk berkomunikasi secara efektif"
                    ],
                    (object)[
                        'name' => 'Multiple Intelegence System',
                        'description' => 'Multiple intelligences sistem merupakan sebuah pendekatan pembelajaran yang mengakui bahwa setiap orang memiliki kecerdasan yang berbeda-beda. Tujuan Multiple Intelligences sistem di imc untuk mengembangkan potensi siswa secara optimal. Setiap siswa memiliki kecerdasan yang unik, sehingga penting untuk mengembangkannya secara maksimal, meningkatkan motivasi belajar siswa. Ketika siswa belajar sesuai dengan kecerdasannya, mereka akan lebih termotivasi untuk belajar dan menciptakan pembelajaran yang lebih efektif dan menyenangkan. MIS memungkinkan guru untuk memberikan pembelajaran yang lebih beragam dan menarik bagi siswa. Dengan menerapkan Multiple intelligences sistem di imc, diharapkan setiap siswa dapat mengembangkan potensinya secara optimal dan mencapai hasil belajar yang maksimal'
                    ],
                    (object)[
                        'name' => 'Soft Skill',
                        'description' => "Kegiatan soft skill di imc adalah kegiatan yang bertujuan untuk mengembangkan kemampuan non-akademik siswa, seperti kemampuan komunikasi, kerja sama, kepemimpinan, dan berpikir kritis. Kegiatan ini penting untuk dilakukan karena soft skill merupakan keterampilan yang dibutuhkan di dunia kerja dan kehidupan sehari-hari."
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc SEHAT',
                'description' => "Program imc Sehat adalah program yang memberikan stimulus Kesehatan kepada peserta didik agar selalu senantiasa menjaga Kesehatan, karena Kesehatan sangat bernilai PENYING dalam kehidupan manusia, melalui kegiatan kegiatan pengecekan dan seminar – seminar Kesehatan yang di isi oleh Wali Murid dengan Konsep PARENT TEACHING memberikan stimulus kepada siswa untuk HIDUP SEHAT.",
                'sub_program' => [
                    (object)[
                        'name' => "Kegiatan Kesehatan",
                        'description' => "Kegiatan kesehatan di imc adalah serangkaian kegiatan yang bertujuan untuk meningkatkan kesehatan dan kesejahteraan siswa. Kegiatan ini dapat berupa penyuluhan / seminar kesehatan, pemeriksaan kesehatan, olahraga, senam bersama dan kegiatan lainnya yang berkaitan dengan kesehatan. Kegiatan kesehatan di imc sangat penting untuk dilakukan agar siswa dapat tumbuh dan berkembang dengan optimal. Dengan adanya kegiatan kesehatan di imc, siswa dapat memiliki pengetahuan dan keterampilan yang dibutuhkan untuk menjaga kesehatannya sendiri."
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc BERPRESTASI',
                'description' => "Program imc Prestasi adalah program yang memberikan stimulus kepada peserta didik untuk berprestasi, kegiatan ini adalah kegiatan khusus dimana peserta didik akan di training dilakukan coaching untuk mendapatkan prestasi baik secara lokal, nasional maupun internasional.",
                'sub_program' => [
                    (object)[
                        'name' => 'Program Khusus Pembinaan',
                        'description' => "Kegiatan khusus pembinaan prestasi siswa di imc adalah kegiatan yang dirancang untuk mengembangkan dan meningkatkan kemampuan siswa dalam bidang tertentu, baik akademik maupun non-akademik. Tujuan kegiatan ini adalah untuk mengembangkan bakat dan minat siswa, meningkatkan prestasi siswa, menyiapkan siswa untuk berkompetisi dan membangun karakter siswa serta meningkatkan rasa percaya diri siswa."
                    ]
                ]
            ],
            (object)[
                'name' => 'PROGRAM imc LEADERSHIP',
                'description' => "Program imc Ledaership adalah program yang memberikan stimulus nilai – nilai kepempinan, melalui kegiatan experience leadership. Peserta Didik mendapatkan pengalaman leadership secara langsung sehingga diharapkan akan memunculkan Jiwa Kepemimpinan.",
                'sub_program' => [
                    (object)[
                        'name' => 'Collaboration',
                        'description' => "Kolaborasi siswa di imc adalah kerja sama antara siswa dalam menyelesaikan tugas atau proyek tertentu. Kegiatan ini bertujuan untuk mengembangkan keterampilan siswa dalam bekerja sama, berkomunikasi, memecahkan masalah, dan berpikir kritis. Kegiatan kolaborasi siswa di imc merupakan hal yang penting untuk dikembangkan. Kegiatan ini dapat membantu siswa untuk mengembangkan keterampilan sosial dan emosional, dan meningkatkan motivasi belajar"
                    ],
                    (object)[
                        'name' => 'Team Building',
                        'description' => "Team Building siswa di sekolah adalah kegiatan yang dilakukan untuk meningkatkan kerja sama, komunikasi, dan kepemimpinan siswa. Kegiatan team building siswa di imc merupakan kegiatan yang penting untuk dilakukan. Kegiatan ini dapat membantu siswa untuk mengembangkan keterampilan dan sikap yang dibutuhkan untuk kesuksesan di masa depan."
                    ],
                    (object)[
                        'name' => 'Problem Solving Discussion',
                        'description' => "Problem solving adalah suatu metode pembelajaran yang mengaktifkan siswa untuk menghadapi berbagai masalah dan dapat mencari pemecahan masalah atau solusi dari permasalahan tersebut. Dengan pelaksanaan kegiatan problem solving yang tepat, siswa akan dapat mengembangkan kemampuan berpikir kritis dan kreatifnya, meningkatkan kemampuan memecahkan masalah siswa, kemampuan kerja sama dan kepercayaan diri siswa. Hal ini akan sangat bermanfaat bagi mereka dalam menghadapi tantangan di dunia nyata."
                    ]
                ]
            ]
        ];

        try {
            DB::beginTransaction();
            foreach ($program_imc as $program) {
                $id = (new Client())->generateId();
                $program_id = DB::table('imc_programs')->insertGetId([
                    'id' => $id,
                    'name' => $program->name,
                    'description' => $program->description ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($program->sub_program as $sub_program) {
                    $id_sub_program = (new Client())->generateId();
                    DB::table('imc_sub_programs')->insert([
                        'id' => $id_sub_program,
                        'program_id' => $id,
                        'name' => $sub_program->name,
                        'description' => $sub_program->description ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
