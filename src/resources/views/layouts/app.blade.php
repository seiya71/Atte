<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <div class="container">
        <header>
            <div class="header-logo">
                <h1>Atte</h1>
            </div>

            @if (Auth::check())
            <div class="header-nav">
                <div class="nav-parts">
                    <a class="nav-parts__link" href="/">ホーム</a>
                </div>
                <div class="nav-parts">
                    <a class="nav-parts__link" href="/attendance">日付一覧</a>
                </div>
                <form class="nav-parts" action="/logout" method="post">
                    @csrf
                    <button type="submit"
                        style="background: none; border: none; font-weight: bold; color: black; cursor: pointer;">
                        ログアウト
                    </button>
                </form>
            </div>
            @endif
            
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            <div class="footer-logo">
                <p>Atte, inc.</p>
            </div>
        </footer>
    </div>
</body>

</html>