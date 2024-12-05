<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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


        return view('index', compact('userName', 'attendance', 'breaktime', 'workCompleted'));
    }

    public function startWork()
    {
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
            ]
        );
        return redirect()->back();
    }

    public function endWork($attendanceId)
    {
        $currentTime = Carbon::now()->format('H:i:s');
        $attendance = Attendance::where('id', $attendanceId)->first();
        if ($attendance) {
            $attendance->update([
                'end_time' => $currentTime,
            ]);
        }

        return redirect()->back();
    }

    public function startBreak($attendanceId)
    {
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


    public function show($date = null)
    {
        $date = $date ?: Carbon::now()->format('Y-m-d');

        $attendances = Attendance::where('date', $date)
            ->with('user', 'breakTimes')
            ->paginate(5);

        $processedData = $attendances->map(function ($attendance) {
            $breakTimeInSeconds = $attendance->breakTimes->reduce(function ($carry, $break) {
                $start = Carbon::parse($break->break_start);
                $end = Carbon::parse($break->break_end);
                return $carry + $start->diffInSeconds($end);
            }, 0);

            $start = Carbon::parse($attendance->start_time);
            $end = Carbon::parse($attendance->end_time);
            $workTimeInSeconds = $start->diffInSeconds($end) - $breakTimeInSeconds;
            $formattedWorkTime = gmdate('H:i:s', $workTimeInSeconds);
            $formattedBreakTime = gmdate('H:i:s', $breakTimeInSeconds);

            return [
                'user_name' => $attendance->user->name,
                'start_time' => $attendance->start_time,
                'end_time' => $attendance->end_time,
                'break_time' => $formattedBreakTime,
                'work_time' => $formattedWorkTime,
            ];
        });
        return view('attendance', compact('processedData', 'date', 'attendances'));
    }

    public function user_list()
    {
        $employees = User::all();

        return view('user-list', compact('employees'));
    }

    public function attendance(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);
        $attendances = Attendance::where('user_id', $id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();
        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $attendanceData = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
            $attendance = $attendances->firstWhere('date', $date);
            $breakTimeInSeconds = 0;
            if ($attendance) {
                $breakTimeInSeconds = $attendance->breakTimes->reduce(function ($carry, $break) {
                    $start = Carbon::parse($break->break_start);
                    $end = Carbon::parse($break->break_end);
                    return $carry + $start->diffInSeconds($end);
                }, 0);
            }
            $start = $attendance ? Carbon::parse($attendance->start_time) : null;
            $end = $attendance ? Carbon::parse($attendance->end_time) : null;
            if ($start && $end) {
                $workTimeInSeconds = $start->diffInSeconds($end) - $breakTimeInSeconds;
                $formattedWorkTime = gmdate('H:i:s', $workTimeInSeconds);
                $formattedBreakTime = gmdate('H:i:s', $breakTimeInSeconds);
            } else {
                $formattedWorkTime = '休日';
                $formattedBreakTime = 'なし';
            }

            $attendanceData[] = [
                'date' => $date,
                'status' => $attendance ? '出勤' : '休日',
                'start_time' => $start ? $start->format('H:i') : 'なし',
                'end_time' => $end ? $end->format('H:i') : 'なし',
                'break_time' => $formattedBreakTime,
                'work_time' => $formattedWorkTime,
            ];
        }
        return view('user-attendance', [
            'user' => $employee,
            'year' => $year,
            'month' => $month,
            'attendanceData' => $attendanceData,
        ]);
    }

}