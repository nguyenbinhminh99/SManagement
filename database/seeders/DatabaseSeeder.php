<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\StudentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        DB::table('users')->insert(
//            [
//                'username' => 'minhnb',
//                'password' => '123456',
//                'email' => 'minhmocmeo0@gmail.com',
//                'firstname' => 'Minh',
//                'lastname' => 'Nguyen',
//                'phone_number' => '0834966966',
//                'gender' => 'male',
//            ]
//        );
        $this->call([
            SchoolSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StudentSeeder::class
        ]);
        \App\Models\Student::factory(100)->create();
    }
}
