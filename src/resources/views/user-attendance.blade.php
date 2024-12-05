@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/suer-attendance.css') }}" />
@endsection

@section('content')

<h2>{{ $user->name }}さんの{{ $year }}年{{ $month }}月の勤務状況</h2>

<table border="1" style="width: 100%; text-align: center;">
    <thead>
        <tr>
            <th>日付</th>
            <th>出勤時間</th>
            <th>退勤時間</th>
            <th>休憩時間</th>
            <th>労働時間</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendanceData as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data['date'])->format('j') }}日</td> <!-- 日付のみ表示 -->
                <td>{{ $data['start_time'] }}</td>
                <td>{{ $data['end_time'] }}</td>
                <td>{{ $data['break_time'] }}</td>
                <td>{{ $data['work_time'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div>
    <a href="{{ route('employees.attendance', [
    'id' => $user->id,
    'year' => $month == 1 ? $year - 1 : $year,
    'month' => $month == 1 ? 12 : $month - 1
]) }}">
        前月
    </a>
    |
    <a href="{{ route('employees.attendance', [
    'id' => $user->id,
    'year' => $month == 12 ? $year + 1 : $year,
    'month' => $month == 12 ? 1 : $month + 1
]) }}">
        翌月
    </a>
</div>
@endsection