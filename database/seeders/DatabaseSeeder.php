<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\DutyMember;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database for Rayon Cisarua 5.
     */
    public function run(): void
    {
        // Pembimbing / Admin Rayon Cisarua 5
        $admin = User::factory()->create([
            'name' => 'Pembimbing Rayon Cisarua 5',
            'email' => 'admin@piket.com',
            'role' => 'admin',
        ]);

        // Daftar 34 Siswa Rayon Cisarua 5 berdasarkan Jadwal Resmi TP 2026/2027
        $studentRoster = [
            // SENIN
            'Senin' => [
                ['name' => 'Hafid Nur Rahman', 'email' => 'hafid@piket.com', 'is_pj' => false],
                ['name' => 'Mohamad Alif Rahman Hakim', 'email' => 'alif@piket.com', 'is_pj' => false],
                ['name' => 'Raden Bilqis Maysa Nurgiviana', 'email' => 'bilqis@piket.com', 'is_pj' => true],
                ['name' => 'Siti Salsa Saida', 'email' => 'salsa@piket.com', 'is_pj' => false],
                ['name' => 'Fahira Zaskya Salsabila', 'email' => 'fahira@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Fathir Khairan', 'email' => 'fathir@piket.com', 'is_pj' => false],
                ['name' => 'Qalesya Azka Anandya Puteri', 'email' => 'qalesya@piket.com', 'is_pj' => false],
            ],
            // SELASA
            'Selasa' => [
                ['name' => 'M Dendiaz Agatisna Putra', 'email' => 'dendiaz@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Farhan Nuriansyah', 'email' => 'farhan@piket.com', 'is_pj' => false],
                ['name' => 'Radiansyah Saripudin', 'email' => 'radiansyah@piket.com', 'is_pj' => true],
                ['name' => 'Sujud Syukur Wicaksana', 'email' => 'sujud@piket.com', 'is_pj' => false],
                ['name' => 'Muhamad Frasya Raffadila', 'email' => 'frasya@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Khayru Ilham', 'email' => 'khayru@piket.com', 'is_pj' => false],
            ],
            // RABU
            'Rabu' => [
                ['name' => 'M. Fiqri Aqias Al Farizi', 'email' => 'fiqri@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Ibnu Shinan', 'email' => 'ibnu@piket.com', 'is_pj' => false],
                ['name' => 'Rasya Dwi Febrian', 'email' => 'rasya@piket.com', 'is_pj' => true],
                ['name' => 'Adiratna Ajeng Artanti', 'email' => 'adiratna@piket.com', 'is_pj' => false],
                ['name' => 'Muhamad Yasa Abdulah', 'email' => 'yasa@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Khoiz Duaza Iskandar', 'email' => 'khoiz@piket.com', 'is_pj' => false],
                ['name' => 'Rival Setiadi Putra', 'email' => 'rival@piket.com', 'is_pj' => false],
            ],
            // KAMIS
            'Kamis' => [
                ['name' => 'M.Iqbal Rafsandani', 'email' => 'iqbal@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Yusup Arba Firdaus', 'email' => 'yusup@piket.com', 'is_pj' => false],
                ['name' => 'Siti Eliza Ahwaliah', 'email' => 'eliza@piket.com', 'is_pj' => true],
                ['name' => 'Anindita Quaneisha Irwansyah', 'email' => 'anindita@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Al- Ghifari Saputro', 'email' => 'ghifari@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Rionaldo', 'email' => 'rionaldo@piket.com', 'is_pj' => false],
                ['name' => 'Zafira Maulida Elvindra', 'email' => 'zafira@piket.com', 'is_pj' => false],
            ],
            // JUMAT
            'Jumat' => [
                ['name' => 'Mochammad Fazriel Muliawan', 'email' => 'fazriel@piket.com', 'is_pj' => false],
                ['name' => 'Naflaisa Kana Haya Gunadi', 'email' => 'naflaisa@piket.com', 'is_pj' => false],
                ['name' => 'Siti Eliana Maulida', 'email' => 'eliana@piket.com', 'is_pj' => true],
                ['name' => 'Bella Rieskya Nova', 'email' => 'bella@piket.com', 'is_pj' => false],
                ['name' => 'Muhammad Fariz Haidar Komarudin', 'email' => 'fariz@piket.com', 'is_pj' => false],
                ['name' => 'Naufal Perdana Putra', 'email' => 'naufal@piket.com', 'is_pj' => false],
                ['name' => 'Rashya Alena Putri', 'email' => 'rashya@piket.com', 'is_pj' => false],
            ],
        ];

        // Buat User Akun untuk setiap siswa
        $usersByDay = [];
        $pjByDay = [];

        foreach ($studentRoster as $day => $students) {
            $usersByDay[$day] = [];
            foreach ($students as $data) {
                $user = User::factory()->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'role' => 'siswa',
                ]);
                $usersByDay[$day][] = [
                    'user' => $user,
                    'is_pj' => $data['is_pj'],
                ];
                if ($data['is_pj']) {
                    $pjByDay[$day] = $user;
                }
            }
        }

        // Mapping hari ke offset (0 = Senin, 1 = Selasa, dst)
        $dayOffsets = [
            'Senin' => 0,
            'Selasa' => 1,
            'Rabu' => 2,
            'Kamis' => 3,
            'Jumat' => 4,
        ];

        // Buat direktori dan sample gambar bukti piket jika belum ada
        $proofDir = storage_path('app/public/proofs');
        if (! file_exists($proofDir)) {
            mkdir($proofDir, 0755, true);
        }
        $sampleImg = $proofDir.DIRECTORY_SEPARATOR.'sample_piket.jpg';
        if (! file_exists($sampleImg)) {
            $img = imagecreatetruecolor(600, 450);
            $bg = imagecolorallocate($img, 15, 23, 42);
            imagefill($img, 0, 0, $bg);
            $white = imagecolorallocate($img, 255, 255, 255);
            $emerald = imagecolorallocate($img, 52, 211, 153);
            imagestring($img, 5, 40, 180, 'BUKTI PIKET KELAS RAYON CISARUA 5', $emerald);
            imagestring($img, 4, 40, 220, 'Lantai Bersih, Papan Tulis Rapi, Meja Tersusun', $white);
            imagestring($img, 3, 40, 260, 'Dokumentasi Tugas Kebersihan TP 2026/2027', $white);
            imagejpeg($img, $sampleImg, 85);
            imagedestroy($img);
        }

        // 1. Jadwal Piket Rayon (Piket Kelas Rayon Cisarua 5)
        foreach ($studentRoster as $day => $members) {
            $offset = $dayOffsets[$day];
            $status = $offset === 0 ? 'sedang_berlangsung' : 'belum_dilakukan';

            $scheduleRayon = Schedule::create([
                'piket_type' => 'piket_rayon',
                'location' => 'Ruang Kelas Rayon Cisarua 5',
                'date' => now()->startOfWeek()->addDays($offset),
                'day' => $day,
                'time' => $day === 'Jumat' ? '11:00:00' : '15:30:00',
                'status' => $status,
            ]);

            // Assign seluruh siswa hari tersebut ke Piket Kelas
            foreach ($usersByDay[$day] as $idx => $item) {
                $dm = DutyMember::create([
                    'schedule_id' => $scheduleRayon->id,
                    'user_id' => $item['user']->id,
                    'is_pj' => $item['is_pj'],
                ]);

                // Seed contoh absensi realistis untuk hari Senin
                if ($day === 'Senin') {
                    if ($item['is_pj']) {
                        // PJ Bilqis sudah Hadir (diverifikasi admin)
                        Attendance::create([
                            'duty_member_id' => $dm->id,
                            'status' => 'hadir',
                            'proof_image' => 'proofs/sample_piket.jpg',
                            'proof_note' => 'Ruang kelas Cisarua 5 selesai dibersihkan. Lantai disapu & dipel, papan tulis bersih, meja guru rapi.',
                            'verified_by' => $admin->id,
                            'verified_at' => now()->subHours(1),
                            'recorded_at' => now()->subHours(2),
                        ]);
                    } elseif ($idx === 1) {
                        // Siswa kedua (Mohamad Alif) kirim foto bukti, MENUNGGU VERIFIKASI PJ
                        Attendance::create([
                            'duty_member_id' => $dm->id,
                            'status' => 'menunggu_verifikasi',
                            'proof_image' => 'proofs/sample_piket.jpg',
                            'proof_note' => 'Lantai ruang kelas sudah dipel wangi dan barisan meja siswa sudah ditata rapi simetris.',
                            'verified_by' => null,
                            'verified_at' => null,
                            'recorded_at' => now()->subMinutes(25),
                        ]);
                    } elseif ($idx === 0) {
                        // Siswa pertama (Hafid) sudah Hadir diverifikasi oleh PJ Bilqis
                        Attendance::create([
                            'duty_member_id' => $dm->id,
                            'status' => 'hadir',
                            'proof_image' => 'proofs/sample_piket.jpg',
                            'proof_note' => 'Papan tulis sudah bersih terhapus dan spidol kelas sudah disusun rapi.',
                            'verified_by' => $pjByDay['Senin']->id,
                            'verified_at' => now()->subMinutes(40),
                            'recorded_at' => now()->subHours(1),
                        ]);
                    } else {
                        // Siswa lainnya belum kirim bukti (Alpa)
                        Attendance::create([
                            'duty_member_id' => $dm->id,
                            'status' => 'alpa',
                            'recorded_at' => now()->subHours(2),
                        ]);
                    }
                }
            }
        }

        // 2. Jadwal Piket WC (Area toilet sekolah yang menjadi tanggung jawab Rayon Cisarua 5)
        $wcLocations = [
            'Senin' => 'WC Siswa Lantai 1 (Tanggung Jawab Cisarua 5)',
            'Selasa' => 'WC Putra Gedung B (Tanggung Jawab Cisarua 5)',
            'Rabu' => 'WC Putri Lantai 2 (Tanggung Jawab Cisarua 5)',
            'Kamis' => 'WC Siswa Lantai 2 (Tanggung Jawab Cisarua 5)',
            'Jumat' => 'WC Area Lapangan (Tanggung Jawab Cisarua 5)',
        ];

        foreach ($wcLocations as $day => $location) {
            $offset = $dayOffsets[$day];
            $status = $offset === 0 ? 'sedang_berlangsung' : 'belum_dilakukan';

            $scheduleWc = Schedule::create([
                'piket_type' => 'piket_wc',
                'location' => $location,
                'date' => now()->startOfWeek()->addDays($offset),
                'day' => $day,
                'time' => $day === 'Jumat' ? '11:15:00' : '15:45:00',
                'status' => $status,
            ]);

            // Ambil 2 siswa dari tim hari tersebut untuk tugas Piket WC
            $dayUsers = $usersByDay[$day];
            $wcAssigned = array_slice($dayUsers, 0, 2);
            foreach ($wcAssigned as $idx => $item) {
                DutyMember::create([
                    'schedule_id' => $scheduleWc->id,
                    'user_id' => $item['user']->id,
                    'is_pj' => $idx === 0,
                ]);
            }
        }

        // 3. Aktivitas Piket Kelas & WC Cisarua 5 (Tanpa Buang Sampah)
        Activity::create([
            'user_id' => $admin->id,
            'title' => 'Menyapu & Mengepel Lantai Ruang Kelas Cisarua 5',
            'description' => 'Membersihkan debu di seluruh permukaan lantai kelas Cisarua 5 lalu mengepel hingga bersih dan wangi.',
            'target_date' => now()->setTime(15, 30),
            'status' => true,
            'done_time' => now()->subMinutes(15),
        ]);

        Activity::create([
            'user_id' => $admin->id,
            'title' => 'Membersihkan Papan Tulis & Merapikan Spidol Kelas',
            'description' => 'Menghapus bersih papan tulis putih dan merapikan penghapus serta spidol di tempatnya.',
            'target_date' => now()->setTime(15, 40),
            'status' => true,
            'done_time' => now()->subMinutes(5),
        ]);

        Activity::create([
            'user_id' => $admin->id,
            'title' => 'Merapikan Barisan Meja, Kursi Siswa & Guru di Kelas',
            'description' => 'Menjajarkan meja dan kursi agar simetris, rapi, dan laci meja bebas dari kotoran/kertas.',
            'target_date' => now()->setTime(15, 50),
            'status' => false,
            'done_time' => null,
        ]);

        Activity::create([
            'user_id' => $admin->id,
            'title' => 'Membersihkan Kaca Jendela & Ventilasi Ruang Kelas',
            'description' => 'Mengelap kaca jendela kelas dan mengibaskan debu dari ventilasi agar sirkulasi udara bersih.',
            'target_date' => now()->setTime(16, 00),
            'status' => false,
            'done_time' => null,
        ]);
    }
}
