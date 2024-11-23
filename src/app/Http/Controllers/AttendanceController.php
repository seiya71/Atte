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

        // Attendancesのデータを取得（ページネーションを適用）
        $attendances = Attendance::where('date', $date)
            ->with('user', 'breakTimes') // 関連するデータをロード
            ->paginate(5); // ページネーションで1ページ5件

        // 加工処理
        $processedData = $attendances->map(function ($attendance) {
            $breakTimeInSeconds = $attendance->breakTimes->reduce(function ($carry, $break) {
                $start = Carbon::parse($break->break_start);
                $end = Carbon::parse($break->break_end);
                return $carry + $start->diffInSeconds($end); // 秒単位で計算
            }, 0);

            $start = Carbon::parse($attendance->start_time);
            $end = Carbon::parse($attendance->end_time);
            $workTimeInSeconds = $start->diffInSeconds($end) - $breakTimeInSeconds; // 秒単位で計算

            // 秒単位の値をH:i:s形式にフォーマット
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

        // ページネーションと加工済みデータをビューに渡す
        return view('attendance', compact('processedData', 'date', 'attendances'));
    }
}