<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schedule;
use App\Models\DutyMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@piket.com'],
            [
                'name' => 'Pembimbing Rayon Cisarua 5',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $roster = [
            'Senin' => [
                ['name' => 'Hafid Nur Rahman', 'is_pj' => false],
                ['name' => 'Mohamad Alif Rahman Hakim', 'is_pj' => false],
                ['name' => 'Raden Bilqis Maysa Nurgiviana', 'is_pj' => true],
                ['name' => 'Siti Salsa Saida', 'is_pj' => false],
                ['name' => 'Fahira Zaskya Salsabila', 'is_pj' => false],
                ['name' => 'Muhammad Fathir Khairan', 'is_pj' => false],
                ['name' => 'Qalesya Azka Anandya Puteri', 'is_pj' => false],
            ],
            'Selasa' => [
                ['name' => 'M Dendiaz Agatisna Putra', 'is_pj' => false],
                ['name' => 'Muhammad Farhan Nuriansyah', 'is_pj' => false],
                ['name' => 'Radiansyah Saripudin', 'is_pj' => true],
                ['name' => 'Sujud Syukur Wicaksana', 'is_pj' => false],
                ['name' => 'Muhamad Frasya Raffadila', 'is_pj' => false],
                ['name' => 'Muhammad Khayru Ilham', 'is_pj' => false],
            ],
            'Rabu' => [
                ['name' => 'M. Fiqri Aqias Al Farizi', 'is_pj' => false],
                ['name' => 'Muhammad Ibnu Shinan', 'is_pj' => false],
                ['name' => 'Rasya Dwi Febrian', 'is_pj' => true],
                ['name' => 'Adiratna Ajeng Artanti', 'is_pj' => false],
                ['name' => 'Muhamad Yasa Abdulah', 'is_pj' => false],
                ['name' => 'Muhammad Khoiz Duaza Iskandar', 'is_pj' => false],
                ['name' => 'Rival Setiadi Putra', 'is_pj' => false],
            ],
            'Kamis' => [
                ['name' => 'M.Iqbal Rafsandani', 'is_pj' => false],
                ['name' => 'Muhammad Yusup Arba Firdaus', 'is_pj' => false],
                ['name' => 'Siti Eliza Ahwaliah', 'is_pj' => true],
                ['name' => 'Anindita Quaneisha Irwansyah', 'is_pj' => false],
                ['name' => 'Muhammad Al- Ghifari Saputro', 'is_pj' => false],
                ['name' => 'Muhammad Rionaldo', 'is_pj' => false],
                ['name' => 'Zafira Maulida Elvindra', 'is_pj' => false],
            ],
            'Jumat' => [
                ['name' => 'Mochammad Fazriel Muliawan', 'is_pj' => false],
                ['name' => 'Naflaisa Kana Haya Gunadi', 'is_pj' => false],
                ['name' => 'Siti Eliana Maulida', 'is_pj' => true],
                ['name' => 'Bella Rieskya Nova', 'is_pj' => false],
                ['name' => 'Muhammad Fariz Haidar Komarudin', 'is_pj' => false],
                ['name' => 'Naufal Perdana Putra', 'is_pj' => false],
                ['name' => 'Rashya Alena Putri', 'is_pj' => false],
            ]
        ];

        $dayOffsets = ['Senin' => 0, 'Selasa' => 1, 'Rabu' => 2, 'Kamis' => 3, 'Jumat' => 4];

        foreach ($roster as $day => $students) {
            // Buat jadwal untuk minggu ini
            $offset = $dayOffsets[$day];
            $scheduleDate = now()->startOfWeek()->addDays($offset);
            
            $schedule = Schedule::create([
                'piket_type' => 'piket_rayon',
                'location' => 'Ruang Kelas Rayon Cisarua 5',
                'date' => $scheduleDate,
                'day' => $day,
                'time' => '15:30:00',
                'status' => 'belum_dilakukan',
            ]);

            foreach ($students as $student) {
                // Generate simple email from first name
                $firstName = strtolower(explode(' ', trim(str_replace('.', '', $student['name'])))[0]);
                $email = $firstName . rand(10,99) . '@piket.com'; // randomize slightly to avoid duplicates
                
                // For Fazriel, make sure we use his specific email so he can login easily
                if (str_contains(strtolower($student['name']), 'fazriel')) {
                    $email = 'fazriel@piket.com';
                }

                $user = User::firstOrCreate(
                    ['name' => $student['name']],
                    [
                        'email' => $email,
                        'role' => 'siswa',
                        'password' => Hash::make('password'),
                    ]
                );

                DutyMember::create([
                    'schedule_id' => $schedule->id,
                    'user_id' => $user->id,
                    'is_pj' => $student['is_pj'],
                ]);
            }
        }
    }
}
