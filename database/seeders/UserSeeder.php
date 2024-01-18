<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'id' => $faker->uuid,
                'first_name' => $faker->firstName,
                'last_name'=> $faker->lastName,
                'avatar'=> $faker->imageUrl($width = 640, $height = 480, 'people'),
                'email' => $faker->unique()->safeEmail,
                'stripe_id' => null,
                'phone_number' => $faker->phoneNumber,
                'email_verified_at' => null,
                'role_cd' => $faker->numberBetween(1,2),
                'province_id' => 12,
                'district_id' => 127,
                'street'=> 'abc',
                'birthday' => $faker->date('Y-m-d'),
                'sex' => 1,
                'education' => 'Đại học',
                'job_current_id' => 4,
                'certificate' => 'https://res.cloudinary.com/dadcmqprj/image/upload/v1697337265/buxnqkr2eq63eyawdwml.png',
                'front_citizen_card' => 'https://res.cloudinary.com/dadcmqprj/image/upload/v1697339796/s1uqoncf3fhwfshyiyoh.jpg',
                'back_citizen_card' => 'https://res.cloudinary.com/dadcmqprj/image/upload/v1697339800/yluntw8sadfaxb6scthy.jpg',
                'title' => 'zzzz',
                'description' => 'description',
                'price' => $faker->numberBetween(100000,200000),
                'type_cd' => $faker->numberBetween(1,2),
                'status_cd' => 1,
                'remember_token' => null,
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
