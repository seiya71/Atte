@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-logo">
    <h2 class="login-logo__text">ログイン</h2>
</div>
<form class="login-form">
    <input class="login-form__input" type="email" placeholder="メールアドレス" />
    <input class="login-form__input" type="password" placeholder="パスワード" />
    <button type="submit">ログイン</button>
</form>
<p class="login-form__text">アカウントをお持ちでない方はこちらから</p>
<a class="login-form__register" href="#">会員登録</a>
@endsection