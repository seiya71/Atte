@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-logo">
    <h2 class="register-logo__text">会員登録</h2>
</div>
<form class="register-form">
    <input class="register-form__input" type="text" placeholder="名前" />
    <input class="register-form__input" type="email" placeholder="メールアドレス" />
    <input class="register-form__input" type="password" placeholder="パスワード" />
    <input class="register-form__input" type="password" placeholder="確認用パスワード" />
    <button type="submit">会員登録</button>
</form>
<p class="register-form__text">アカウントをお持ちの方はこちらから</p>
<a class="register-form__login" href="/login">ログイン</a>
@endsection