<!DOCTYPE html>
<html lang="ja">
<body>
<h3 class="base-font-bold base-font-m">お問い合わせを受付完了</h3>
<p>{{ $userContact->name }} 様</p>
<p class="mb-8">以下内容で、お問い合わせを受け付けました。担当者からご連絡いたしますので、しばらくお待ちください。</p>
<p>項目:{{ $userContact->title }}</p>
<p>内容:{{ $userContact->content }}</p>
</body>
</html>
