@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<div class="register-logo">
    <h2 class="register-logo__text">会員登録</h2>
</div>
<form class="register-form" action="/register" method="post">
    @csrf
    <input class="register-form__input" type="text" name="name" placeholder="名前" />
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror
    <input class="register-form__input" type="email" name="email" placeholder="メールアドレス" />
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror
    <input class="register-form__input" type="password" name="password" placeholder="パスワード" />
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror
    <input class="register-form__input" type="password" name="password_confirmation" placeholder="確認用パスワード" />
    <button type="submit">会員登録</button>
</form>
<p class="register-form__text">アカウントをお持ちの方はこちらから</p>
<a class="register-form__login" href="/login">ログイン</a>
@endsection