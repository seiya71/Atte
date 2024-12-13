<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\BreakTime;
use App\Models\Attendance;

class BreakTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $attendances = Attendance::all();

        foreach ($attendances as $attendance) {
            foreach (range(1, $faker->numberBetween(2, 3)) as $breakCount) {
                $breakStart = Carbon::parse($attendance->start_time)->addHours($faker->numberBetween(2, 4))->addMinutes($faker->numberBetween(0, 59));
                $breakEnd = $breakStart->copy()->addMinutes($faker->numberBetween(15, 60));

                if ($breakEnd->greaterThan(Carbon::parse($attendance->end_time))) {
                    break;
                }

                BreakTime::create([
                    'attendance_id' => $attendance->id,
                    'break_start' => $breakStart->toDateTimeString(),
                    'break_end' => $breakEnd->toDateTimeString(),
                ]);
            }
        }
    }
}
