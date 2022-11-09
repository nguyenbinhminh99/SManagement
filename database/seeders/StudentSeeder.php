<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::create([
            'email' => 'admin@gmail.com',
            'firstname' => 'Minh',
            'lastname' => 'Nguyen',
            'phone_number' => '0834966966',
            'gender' => 'male',
            'identification' => '46347364623',
            'address' => 'Ha Noi',
            'school_id' => 1
        ]);
    }
}
