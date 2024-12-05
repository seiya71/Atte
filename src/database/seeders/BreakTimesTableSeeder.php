<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BreakTime;

class BreakTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $attendances = DB::table('attendances')->get();

        foreach ($attendances as $attendance) {
            $breakStart = Carbon::parse($attendance->start_time)->addHours($faker->numberBetween(2, 4));
            $breakEnd = (clone $breakStart)->addMinutes($faker->numberBetween(15, 60));

            DB::table('break_times')->insert([
                'attendance_id' => $attendance->id,
                'break_start' => $breakStart->toDateTimeString(),
                'break_end' => $breakEnd->toDateTimeString(),
            ]);
        }
    }
}
