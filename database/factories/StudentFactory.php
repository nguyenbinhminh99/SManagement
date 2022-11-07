<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = array('male', 'female');
        $permitted_chars = '0123456789';
        for ($i =0; $i < 100; $i++){
            $rdIdentification = substr(str_shuffle($permitted_chars), 0, 12);
        }
        return [
            'firstname' => fake() ->firstName(),
            'lastname' => fake() ->lastName(),
            'email' => fake()->safeEmail(),
            'phone_number' => fake() ->phoneNumber(),
            'gender' =>  $gender[array_rand($gender)],
            'identification' => $rdIdentification,
            'address' => fake() ->address(),
        ];
    }
}
