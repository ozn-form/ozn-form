<!-- @@master ../../../layout/sample.html {"title": "ステップ", "relative_path": "../..", "step_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'step.json';


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
////    'SMTPSecure' => 'tls',    // 'ssl' or 'tsl'
//
//    'Port'       => 465,
//    'SMTPSecure' => 'ssl',
//);


// Gmail アカウント設定（Gmail SMTP 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

$gmail_user     = "oznform@gmail.com";
$gmail_password = "nNeT7FYANyWtDX";


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
<!-- @@close -->

<!-- @@block content -->

<div class="page-header">
    <h1>
        お問い合わせ
        <small>送信完了</small>
    </h1>


    <div class="row">
        <p class="col-sm-12 text-center">
            <a href="/document/samples/step/index.php" class="btn btn-success">フォームトップへ戻る</a>
        </p>
    </div>
</div>

<!-- @@close -->