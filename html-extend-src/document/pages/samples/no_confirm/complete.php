<!-- @@master ../../../layout/sample.html {"title": "確認画面なし", "relative_path": "../../", "no_confirm_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'no_confirm.json';


// SMTP アカウント設定（SMTP 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

//$account  = "Account@test.to";
//$password = "Password";
//$host     = "smtp.lolipop.jp";  // SMTPサーバ
//
//$smtp_options = array(
//
////    デフォルト設定
////    'SMTPAuth'   => true,
////    'Port'       => 587,
////    'SMTPSecure' => 'tls',    // 'ssl' or 'tls'
//
//    'Port'       => 465,
//    'SMTPSecure' => 'ssl',
//);


// Gmail アカウント設定（Gmail SMTP 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

$gmail_user     = "yourGmailAddress";
$gmail_password = "YourGmailPassword";

// Gmail API設定（Gmail SMTP [OAuth認証] 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

//$gmail_user   = 'oznform@gmail.com';
//$oauth_id     = "";
//$oauth_secret = "";
//$oauth_refresh_token = "";


/**
 * メールテンプレートについて
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * フォームの NAME値 をタグに用いることによってメールテンプレート中のタグをフォーム入力値で置換できます。
 *
 * 【例】
 *  フォームHTML:
 *      <input name="last_name" value="田中"> <input name="first_name" value="一郎">
 *  テンプレート中のタグ表記:
 *      <% last_name %> <% first_name %> 様
 *  テンプレート置換例:
 *      田中 一郎 様
 *
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

sleep(3);

// 管理者宛メールの設定
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

// 管理者宛メールタイトル
$admin_mail_title = '[<% {send_date} %>] <% customer_name %> 様より、お問い合わせがありました';

// 管理者宛メールテンプレート
$admin_mail_body = <<< TEXT

Webフォームにて <% customer_name %> 様よりお問合せがありました。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
お名前： <% customer_name %>
<%% if.customer_kana %%>よみがな： <% customer_kana %><%% endif %%>
ご住所： 〒<% zip-code %> <% address1 %> <% address2 %>
メールアドレス： <% email %>

<%% if.mail_body %%>お問い合わせ内容：
<% mail_body %> <%% endif %%>


- - - - - - - - - - - - - - - - - - - - - - - - -
送信シリアルNo：<% {serial} %>
送信元エージェント：<% {user_agent} %>
参照元：<% {referrer} %>
送信日時：<% {send_date} %>

TEXT;


// 自動返信メールの設定（送信しない場合は必要なし）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

// 自動返信メールタイトル
$customer_mail_title = '<% customer_name %>さま、お問合せありがとうございます';

// 自動返信メールテンプレート
$customer_mail_body = <<< TEXT

下記の通り、承りました。お問合せありがとうございました。
2〜3営業日以内にお返事いたします。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
お名前： <% customer_name %>
<%% if.customer_kana %%>よみがな： <% customer_kana %><%% endif %%>
ご住所： 〒<% zip-code %> <% address1 %> <% address2 %>
メールアドレス： <% email %>

TEXT;


// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';

?>

<!-- 送信完了画面のHTMLをここから下に記述する。特定ページへリダイレクトする場合は省略可。 -->
<!-- @@close -->

<!-- @@block content -->

<div class="page-header">
    <h1>
        お問い合わせサンプル（ノーマル版）
        <small>送信完了</small>
    </h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <ol class="ozn-form-stepbar step2 hidden-xs">
        <li>1. 内容の入力</li>
        <li class="current">2. 送信完了</li>
    </ol>
    <ol class="ozn-form-stepbar step2 visible-xs-block">
        <li>入力</li>
        <li class="current">完了</li>
    </ol>
</div>

<div class="ozn-form-container ozn-form-complete">

    <div class="ozn-form-lead">
        <h2>送信完了しました</h2>
        <p>お問い合わせありがとうございました。<br />
            担当者が内容を確認の上、改めてご連絡いたします。<br />
            今しばらくお待ちください。</p>
    </div>

</div>

<!-- @@close -->
