@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="greeting">
    <h2 class="greeting__text">福場凛太郎さんお疲れ様です！</h2>
</div>
<div class="button-grid">
    <button class="stamp-button">勤務開始</button>
    <button class="stamp-button">勤務終了</button>
    <button class="stamp-button">休憩開始</button>
    <button class="stamp-button">休憩終了</button>
</div>
@endsection