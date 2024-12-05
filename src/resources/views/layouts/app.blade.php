<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo">
                    Atte
                </a>
                <nav>
                    <ul class="header-nav">
                        @if (Auth::check())
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/">ホーム</a>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('attendance') }}">日付一覧</a>
                        </li>
                        <!-- ユーザー一覧リンクの追加 -->
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="{{ route('users.index') }}">ユーザー一覧</a>
                        </li>

                        <li class="header-nav__item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- フッターの追加 -->
    <footer class="footer">
        <div class="footer__inner">
            <p>Atte.inc,</p>
        </div>
    </footer>

</body>

</html>
</body>

</html>