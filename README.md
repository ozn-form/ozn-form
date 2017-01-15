# OZN-Form（仮）

コーポレートサイト用 汎用PHPメールフォーム  
下記記載事項は未実装未決定です。こうする予定という感じで…

## PHPバージョン
開発時バージョン：PHP5.6  
リリース前検証：PHP5.3, 5.6, 7.0

## 依存ライブラリ

### PHP
PHPMailer - メール送信 | [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)  
Valitron - 入力値検証 | [https://github.com/vlucas/valitron](https://github.com/vlucas/valitron)  
oauth2-client - OAuth接続クライアント | [https://github.com/thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client)  
oauth2-google - Google XOAuth接続クライアント | [https://github.com/thephpleague/oauth2-google](https://github.com/thephpleague/oauth2-google)  

### フロントエンド
gulp | http://gulpjs.com/

ajaxzip3 - 郵便番号住所検索 | https://github.com/ajaxzip3/ajaxzip3.github.io  
autokana - ふりがな自動挿入 | https://github.com/harisenbon/autokana


## 認証情報
### テスト送信用Googleアカウント

account: oznform@gmail.com  
password: nNeT7FYANyWtDX


## テスト実行について

1. PHPビルドインサーバー起動（ドキュメントルートはreleaseディレクトリ）  
/usr/bin/php -S localhost:8080 -t /path/to/ozn-form/release/

2. ブラウザで下記URLにアクセス  
http://localhost:8080/document/sample_form/index.php


サンプルフォームは テスト送信用Googleアカウント のSMTP接続で送信しています。

## ファイル構成（下記は旧構成、後で更新します…）

|ディレクトリ構成|説明|
|---------------|----|
|ozn-form | プロジェクトルート|
|├ assets | 変換前のSassソースなどの置き場所| 
|├ release | OznForm 実行ファイル群|
|│ ├ document | ドキュメント。フォーム実行時には不要|
|│ ├ lib | OznFrom ライブラリ用ディレクトリ|
|│ ├ js | OznForm Javascript ディレクトリ|
|│ ├ css | OznForm StyleSheet ディレクトリ|
|│ ├ vendor | Comporser ライブラリ ディレクトリ|  
|│ ├ index.html | ダミーインデックス|
|│ └ ozn-form.php | OznForm 実行ファイル|
|├ node_modules | Node.js ライブラリ用ディレクトリ（リポジトリには含めていない）|


## 使い方

1. ozn-form/release ディレクトリをコピーしてサイトに配置
2. フォーム設定ファイルを作成
3. フォームファイル（例：step1.php）などに下記PHPコードをコピー＆ペースト
4. Let's Fun!!

## ↓ 仕様メモ

## やること
* デザイン改善
* それに伴うコーディング 
* EFOの参考サイト（後述）にあるようなクライアントサイドのスクリプト追加
* メールフォームプログラムそのものの費用

## デザイン・HTML的要望
* 入力欄を大きく
* 必須、任意のラベル、入力例を分かりやすく
* 入力中項目ハイライト
* 姓名や電話の局番欄は分けない
* レスポンシブで作成（汎用化を考えるとBootstrapなどメジャーなCSSフレームワーク使用？）
* スマートフォンで使いやすいように
* 可能なものはautocomplete属性を指定

## クライアントサイド要望（既存ライブラリ使用OK、上から順に優先度高）
* JSによるリアルタイムバリデーション（エラーがないときはグリーン表示する）
* リアルタイムバリデーションはフキダシ型ポップアップではなく普通のテキスト表示がよい
* 郵便番号から住所補完
* 名前の漢字入力からのふりがな補完
* フォーム画面から送信以外のアクションで離脱する際に、アラートを表示
* エンターキーでの誤送信を防ぐ
* メールアドレス部分のドメインサジェスト（不要かもしれないので見積承認後確認）
* 開催日時をDatepickerに（ただし「開催月と平日か休日かでも見積可能です。」とあるので自由記述でもよいかも。見積承認後確認）

※盛り込み過ぎで問題が出そうな場合は削る提案もOK

## サーバサイド要望
* PHPを使用、バージョンについては後述
* 特定のフレームワークに依存しない
* 全角英数字はバリデーションエラーを出さずシステム側で変換対応
* 自動返信メール文面、送信先指定はconfigファイルで指定可能に
* 管理者向けメールで取得・表示したい内容
    * 送信元ユーザーエージェント
    * 送信日時（メールのタイムスタンプとは別に本文内に入れたい）

## 対象サイトのPHP環境
PHP 5.6.8 
http://test.event-partners.net/i.php

今後別サイトでの流用を考えると、PHP 7.0.xにも対応しておきたい。
古い方のバージョンへの対応としては、5.2系はほぼないので切ってよい。5.3はまだ残っているが、まぁいいかな…という感じ
5.4, 5.5が使えるサーバは5.6も使えることが多いので、このあたりの対応については工数と相談のうえ決定。


## 依頼主様のご要望
* 以下の記事に記載のことを取り入れたい。特に2つ目のエバーライフのフォームは是非参考にしたいとのこと
    * http://digitalidentity.co.jp/service/efo/points.html
    * http://www.webdesign-fan.com/cvr-form
    * https://webkikaku.co.jp/blog/htmlcss/form_js_customize/
    * http://mamion.net/2014/12/%E7%9A%87%E6%BD%A4%E3%81%AE%E5%85%A5%E5%8A%9B%E3%83%95%E3%82%A9%E3%83%BC%E3%83%A0%E3%81%8C%E4%BD%BF%E3%81%84%E3%82%84%E3%81%99%E3%81%84%E7%90%86%E7%94%B1/
* 入力項目は現状ママでOK
* 完了画面は以下のような感じで30分後の日時を表示する（既存ページあり）
　http://www.event-partners.net/thanks


## 今回のお客さんの要件にはないが、汎用化を考えた時に対応しておきたい内容
* 入力ページ、確認ページ、完了ページのHTMLは柔軟にコーディングできるように
* 入力エラーメッセージを項目ごとに柔軟に指定できるように
* 同サイトに複数のフォームを設置したい場合、コアファイルは1つだけで済むように
* ファイル添付機能（image.jpgみたいな同一ファイル名が複数添付されたときのリネーム機能も必要かも）
* 未入力項目は確認画面や自動返信メール文面に反映しない
* 任意の入力項目のvalueをメールの件名にも反映できるようにしたい（もしくは任意のラジオボタンの選択肢で件名切り分け）
* メールフォームへの流入リファラ取得（フォームの1つ前に見ていたページがわかるとベスト）

## さらに拡張バージョン
* 入力ステップ分割バージョン（入力内容1→入力内容2→確認→完了）