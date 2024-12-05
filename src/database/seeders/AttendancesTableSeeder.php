<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Attendance;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ja_JP');

        foreach (range(1, 100) as $userId) {
            foreach (range(1, 30) as $day) {
                $start = Carbon::create(2024, 11, $day, $faker->numberBetween(8, 10), $faker->numberBetween(0, 59));
                $end = $start->copy()->addHours($faker->numberBetween(7, 9))->addMinutes($faker->numberBetween(0, 59));
                Attendance::create([
                    'user_id' => $userId,
                    'date' => $start->format('Y-m-d'),
                    'start_time' => $start->format('H:i:s'),
                    'end_time' => $end->format('H:i:s'),
                ]);
            }
        }
    }
}
