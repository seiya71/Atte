<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
</head>

<body>
    <div class="container">
        <header>
            <div class="header-logo">
                <h1>Atte</h1>
            </div>
        </header>
        <main>
            <h1>メールアドレスの確認</h1>
            <p>登録時に送信されたメールを確認し、記載されているリンクをクリックしてください。</p>
            <p>メールが届いていない場合は、以下のボタンで再送信できます。</p>
            
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit">確認メールを再送信</button>
            </form>
        </main>
        <footer>
            <div class="footer-logo">
                <p>Atte, inc.</p>
            </div>
        </footer>
    </div>
</body>

</html>