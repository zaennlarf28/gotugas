<?php
namespace Database\Seeders;

use App\Models\User;
use DB;
// import
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gotugas.qzz.io',
            'password' => bcrypt('rahasia'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru',
            'email' => 'guru@gotugas.qzz.io',
            'password' => bcrypt('rahasia'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@gotugas.qzz.io',
            'password' => bcrypt('rahasia'),
            'role' => 'siswa',
        ]);

    }
}