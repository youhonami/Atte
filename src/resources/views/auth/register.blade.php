@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register-form__heading">
        <h1 class="register__title">会員登録</h1>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <!-- 名前入力 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="名前" />
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- メールアドレス入力 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- パスワード入力 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password" placeholder="パスワード" />
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- 確認用パスワード入力 -->
        <div class="form__group">
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password_confirmation" placeholder="確認用パスワード" />
                </div>
                <div class="form__error">
                    @error('password_confirmation')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <!-- 登録ボタン -->
        <div class="form__button">
            <button class="form__button-submit" type="submit">登録</button>
        </div>
    </form>
    <div class="login__link">
        <p class="login__text">アカウントをお持ちの方はこちらから</p>
        <a class="login__button-submit" href="/login">ログイン</a>
    </div>
</div>
@endsection