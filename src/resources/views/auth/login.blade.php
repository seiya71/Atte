@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('content')
<div class="login-logo">
    <h2 class="login-logo__text">ログイン</h2>
</div>
<form class="login-form" action="/login" method="post">
    @csrf
    <input class="login-form__input" type="email" name="email" placeholder="メールアドレス" />
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
    <input class="login-form__input" type="password" name="password" placeholder="パスワード" />
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror
    <button type="submit">ログイン</button>
</form>
<p class="login-form__text">アカウントをお持ちでない方はこちらから</p>
<a class="login-form__register" href="/register">会員登録</a>
@endsection