<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');

        foreach (range(1, 100) as $index) {
            DB::table('users')->insert([
                'name' => $faker->lastName . $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
