<!DOCTYPE html>
<html lang="ja">
<body>
<h1 class="base-font-bold base-font-m">【ユーザー】お問い合わせのお知らせ</h1>
<p class="mb-8">以下内容で、お問い合わせがありました。</p>
<p>氏名:{{ $userContact->name }}</p>
<p>メールアドレス:{{ $userContact->email }}</p>
<p>電話番号:{{ $userContact->tel }}</p>
<p>項目:{{ $userContact->title }}</p>
<p>内容:{{ $userContact->content }}</p>
</body>
</html>
