@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="greeting">
    <h2 class="greeting__text"> {{ $userName }} さんお疲れ様です！</h2>
</div>
<div class="button-grid">
    <form action="{{ route('work.start') }}" method="POST">
        @csrf
        <button class="stamp-button" type="submit" @if ($workCompleted || $attendance) disabled @endif>
            勤務開始
        </button>
    </form>
    
    <form action="{{ route('work.end', $attendance->id ?? '') }}" method="POST">
        @csrf
        <button class="stamp-button" type="submit" @if ($workCompleted || !$attendance || $breaktime) disabled @endif>
            勤務終了
        </button>
    </form>
    
    <form action="{{ route('break.start', $attendance->id ?? '') }}" method="POST">
        @csrf
        <button class="stamp-button" type="submit" @if ($workCompleted || !$attendance || $breaktime) disabled @endif>
            休憩開始
        </button>
    </form>
    
    <form action="{{ route('break.end', $breaktime->id ?? '') }}" method="POST">
        @csrf
        <button class="stamp-button" type="submit" @if ($workCompleted || !$breaktime) disabled @endif>
            休憩終了
        </button>
    </form>
</div>
@endsection