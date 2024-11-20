<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\BreakTime;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $userName = $user ? $user->name : '';
        $userId = $user ? $user->id : '';

        $attendance = Attendance::where('user_id', $userId)
            ->whereNull('end_time')
            ->first();

        $workCompleted = Attendance::where('user_id', $userId)
            ->whereDate('date', $today)
            ->whereNotNull('end_time')
            ->exists();

        $breaktime = null;
        if ($attendance) {
            $breaktime = BreakTime::where('attendance_id', $attendance->id)->whereNull('break_end')->first();
        }


        return view('index', compact('userName','attendance', 'breaktime', 'workCompleted'));
    }

    public function startWork(){
        $userId = Auth::id();
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $userId,
                'date' => $currentDate,
                'end_time' => null
            ],
            [
                'start_time' => $currentTime,
            ]);
        return redirect()->back();
    }

    public function endWork($attendanceId){
        $currentTime = Carbon::now()->format('H:i:s');
        $attendance = Attendance::where('id', $attendanceId)->first();
        if ($attendance) {
            $attendance->update([
                'end_time' => $currentTime,
            ]);
        }

        return redirect()->back();
    }

    public function startBreak($attendanceId){
        $currentTime = Carbon::now()->format('H:i:s');
        BreakTime::create([
            'attendance_id' => $attendanceId,
            'break_start' => $currentTime,
        ]);

        return redirect()->back();
    }

    public function endBreak($breakId)
    {
        $currentTime = Carbon::now()->format('H:i:s');

        BreakTime::where('id', $breakId)->update([
            'break_end' => $currentTime,
        ]);

        return redirect()->back();
    }
}
