<!DOCTYPE html>
<html lang="ja">
<body>
<h1 class="base-font-bold text-2xl">アカウント新規登録のお知らせ</h1>
<p class="mb-8">以下内容で、アカウント発行を承りました。ログインのうえ、パスワードの変更をお願いします。</p>
<p>メールアドレス:{{ $email }}</p>
<p>初期パスワード:{{ $password }}</p>
<p>ログインリンク:<a href="{{ $login_url  }}">{{ $login_url  }}</a></p>
</body>
</html>
