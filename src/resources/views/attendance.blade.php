@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />
@endsection

@section('content')
<div class="date-navigation">
    <a href="{{ route('attendance.show', ['date' => \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')]) }}">&lt;</a>
    <h2>{{ $date }}</h2>
    <a href="{{ route('attendance.show', ['date' => \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d')]) }}">&gt;</a>
</div>

<table>
    <thead>
        <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($processedData as $row)
            <tr>
                <td>{{ $row['user_name'] }}</td>
                <td>{{ $row['start_time'] }}</td>
                <td>{{ $row['end_time'] }}</td>
                <td>{{ $row['break_time'] }}</td>
                <td>{{ $row['work_time'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    <!-- 前のページ -->
    <a href="{{ $attendances->previousPageUrl() ?? '#' }}"
        class="prev {{ $attendances->onFirstPage() ? 'disabled' : '' }}">&lt;</a>

    @php
        $current = $attendances->currentPage();
        $last = $attendances->lastPage();
    @endphp

    @if ($current <= 10)
        <!-- 前半の表示 -->
        @foreach (range(1, 10) as $page)
            <a href="{{ $attendances->url($page) }}" class="{{ $page == $current ? 'active' : '' }}">
                {{ $page }}
            </a>
        @endforeach

        @if ($last > 10)
            <!-- 「...」を11ページへのリンクにする -->
            <a href="{{ $attendances->url(11) }}" class="dots">...</a>
            <a href="{{ $attendances->url($last - 1) }}" class="{{ $current == $last - 1 ? 'active' : '' }}">
                {{ $last - 1 }}
            </a>
            <a href="{{ $attendances->url($last) }}" class="{{ $current == $last ? 'active' : '' }}">
                {{ $last }}
            </a>
        @endif

    @else
        <!-- 後半の表示 -->
        <a href="{{ $attendances->url(1) }}" class="{{ $current == 1 ? 'active' : '' }}">1</a>
        <a href="{{ $attendances->url(2) }}" class="{{ $current == 2 ? 'active' : '' }}">2</a>
        <!-- 「...」を10ページへのリンクにする -->
        <a href="{{ $attendances->url(10) }}" class="dots">...</a>

        @foreach (range(11, $last) as $page)
            <a href="{{ $attendances->url($page) }}" class="{{ $page == $current ? 'active' : '' }}">
                {{ $page }}
            </a>
        @endforeach
    @endif

    <!-- 次のページ -->
    <a href="{{ $attendances->nextPageUrl() ?? '#' }}"
        class="next {{ !$attendances->hasMorePages() ? 'disabled' : '' }}">&gt;</a>
</div>
@endsection