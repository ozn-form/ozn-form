<?php

// SMTP アカウント設定（SMTP 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

$account  = "Account@test.to";
$password = "Password";
$host     = "mailhog";  // SMTPサーバ

$smtp_options = array(

//    デフォルト設定
//    'SMTPAuth'   => true,
//    'Port'       => 587,
//    'SMTPSecure' => 'tls',    // 'ssl' or 'tls'

    'Port'       => 1025,
    'SMTPSecure' => 'none',
);


// Gmail アカウント設定（Gmail SMTP 経由で送信する時のみ）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

//$gmail_user     = "";
//$gmail_password = "";


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
$admin_mail_title = '<% title %>のお問い合わせがありました';

// 管理者宛メールテンプレート
$admin_mail_body = <<< TEXT
Webサイトから下記の内容でお問い合わせがありました。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<%% if.title %%>■お問い合わせ種別： <% title %><%% endif %%>
<%% if.customer_name %%>■お名前： <% customer_name %><%% endif %%>
<%% if.customer_kana %%>■フリガナ： <% customer_kana %><%% endif %%>
<%% if.address %%>■ご住所： <%% endif %%><%% if.zip-code %%>〒<% zip-code %><%% endif %%>
　　　　<% pref %><% address %><%% if.address-building %%>
　　　　<% address-building %><%% endif %%>
<%% if.email %%>■メールアドレス： <% email %><%% endif %%>
<%% if.tel %%>■電話番号： <% tel %><%% endif %%>

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<%% if.materials %%>■ご興味のある商品： <% materials %><%% endif %%><%% if.materials-etc %%>
　　　　その他の商品名： <% materials-etc %><%% endif %%><%% if.shipping-date %%>
■ご希望納期： <% shipping-date %>までに必要<%% endif %%>
<%% if.mail_body %%>■お問い合わせ内容： <% mail_body %><%% endif %%>
<%% if.survey[] %%>■当社を何で知りましたか ： <% survey[] %><%% endif %%>

- - - - - - - - - - - - - - - - - - - - - - - - -
送信シリアルNo：<% {serial} %>
送信元エージェント：<% {user_agent} %>
参照元：<% {referrer} %>
送信日時：<% {send_date} %>


TEXT;


// 自動返信メールの設定（送信しない場合は必要なし）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

// 自動返信メールタイトル
$customer_mail_title = 'サンプル株式会社へのお問い合わせありがとうございます';

// 自動返信メールテンプレート
$customer_mail_body = <<< TEXT

<% customer_name %>様

サンプル株式会社へのお問い合わせ、ありがとうございます。
本メールはメールフォームより送信した内容をお知らせする自動返信メールです。
送信された内容は下記の通りですのでお確かめください。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<%% if.title %%>■お問い合わせ種別： <% title %><%% endif %%>
<%% if.customer_name %%>■お名前： <% customer_name %><%% endif %%>
<%% if.customer_kana %%>■フリガナ： <% customer_kana %><%% endif %%>
<%% if.address %%>■ご住所： <%% endif %%><%% if.zip-code %%>〒<% zip-code %><%% endif %%>
　　　　<% pref %><% address %><%% if.address-building %%>
　　　　<% address-building %><%% endif %%>
<%% if.email %%>■メールアドレス： <% email %><%% endif %%>
<%% if.tel %%>■電話番号： <% tel %><%% endif %%>

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<%% if.materials %%>■ご興味のある商品： <% materials %><%% endif %%><%% if.materials-etc %%>
　　　　その他の商品名： <% materials-etc %><%% endif %%><%% if.shipping-date %%>
■ご希望納期： <% shipping-date %>までに必要<%% endif %%>
<%% if.mail_body %%>■お問い合わせ内容： <% mail_body %><%% endif %%>
<%% if.survey[] %%>■当社を何で知りましたか ： <% survey[] %><%% endif %%>
- - - - - - - - - - - - - - - - - - - - - - - - - - -

担当者が内容を確認の上、改めてご連絡いたします。

=======================================================
サンプル株式会社
〒000-0000 住所
TEL：  FAX： 
URL: http://
=======================================================

- - - - - - - - - - - - - - - - - - - - - - - - -
送信シリアルNo：<% {serial} %>
送信元エージェント：<% {user_agent} %>
参照元：<% {referrer} %>
送信日時：<% {send_date} %>

TEXT;

// 設定ファイルのパスを設定
$config_path = __DIR__ . '/normal.json';

// OznForm 実行ファイル読み込み
require __DIR__ . '/../../release/ozn-form/ozn-form.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ozn-form Documents - ノーマル</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="../../css/style.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php echo $ozn_form_styles; ?>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
    <?php echo $ozn_form_javascript; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="">


<div class="container">

<div class="page-header">
    <h1>
        お問い合わせサンプル（ノーマル版）
        <small>送信完了</small>
    </h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <ol class="ozn-form-stepbar step3 hidden-xs">
        <li>1. 内容の入力</li>
        <li>2. 内容確認</li>
        <li class="current">3. 送信完了</li>
    </ol>
    <ol class="ozn-form-stepbar step3 visible-xs-block">
        <li>入力</li>
        <li>確認</li>
        <li class="current">完了</li>
    </ol>
</div>

<div class="ozn-form-container ozn-form-complete">

    <div class="ozn-form-lead">
        <h2>送信完了しました</h2>
        <p>お問い合わせありがとうございました。<br />
            担当者が内容を確認の上、改めてご連絡いたします。<br />
            今しばらくお待ちください。</p>
        <p>&raquo;<a href="" title="HOME">トップページへ戻る</a></p>
    </div>

</div>


</div>

<hr class="setting-hr">
<footer>
    <div class="container">
        <p>&copy; ozone notes / 西三河情報システム</p>
    </div>
</footer>

</body>
</html>
