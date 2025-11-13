<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Classes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name'      => 'User Admin',
            'telepon'   => '081234567890',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
        ]);

        User::create([
            'name'      => 'Guru Kelas I',
            'telepon'   => '081234567891',
            'email'     => 'guru1@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);

        User::create([
            'name'      => 'Guru Kelas II',
            'telepon'   => '081234567892',
            'email'     => 'guru2@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);

        User::create([
            'name'      => 'Guru Kelas III',
            'telepon'   => '081234567893',
            'email'     => 'guru3@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);

        User::create([
            'name'      => 'Guru Kelas IV',
            'telepon'   => '081234567894',
            'email'     => 'guru4@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);

        User::create([
            'name'      => 'Guru Kelas V',
            'telepon'   => '081234567895',
            'email'     => 'guru5@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);

        User::create([
            'name'      => 'Guru Kelas VI',
            'telepon'   => '081234567896',
            'email'     => 'guru6@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'guru',
        ]);




        Classes::create([
            'nama_kelas' => 'Kelas 1',
            'wali_kelas' => 2,
        ]);

        Classes::create([
            'nama_kelas' => 'Kelas 2',
            'wali_kelas' => 3,
        ]);

        Classes::create([
            'nama_kelas' => 'Kelas 3',
            'wali_kelas' => 4,
        ]);

        Classes::create([
            'nama_kelas' => 'Kelas 4',
            'wali_kelas' => 5,
        ]);

        Classes::create([
            'nama_kelas' => 'Kelas 5',
            'wali_kelas' => 6,
        ]);

        Classes::create([
            'nama_kelas' => 'Kelas 6',
            'wali_kelas' => 7,
        ]);


        
    }
}
