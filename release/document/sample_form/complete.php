<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'sample_form1.json';


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
$admin_mail_title = 'web：<% customer_name %> 様より、お問い合わせがありました';

// 管理者宛メールテンプレート
$admin_mail_body = <<< TEXT

Webフォームにて <% customer_name %> 様よりお問合せがありました。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
お名前： <% customer_name %>
<%% if.customer_kana %%>よみがな： <% customer_kana %><%% endif %%>
ご住所： 〒<% zip-code %> <% address1 %> <% address2 %>
<%% if.tel %%>電話番号： <% tel %><%% endif %%>
メールアドレス： <% email %>

<%% if.mail_body %%>お問い合わせ内容：
<% mail_body %> <%% endif %%>

- - - - - - - - - - - - - - - - - - - - - - - - - - -
資料送付： <% materials %>
配送希望日： <% shipping-date %>
送付先ご住所： 〒<% shipping-zip-code1 %>-<% shipping-zip-code2 %> <% shipping-address1 %> <% shipping-address2 %>

<%% if.survey[] %%>アンケート： <% survey[] %><%% endif %%>

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
<%% if.tel %%>電話番号： <% tel %><%% endif %%>
メールアドレス： <% email %>

- - - - - - - - - - - - - - - - - - - - - - - - - - -
資料送付： <% materials %>
配送希望日： <% shipping-date %>
送付先ご住所： 〒<% shipping-zip-code1 %>-<% shipping-zip-code2 %> <% shipping-address1 %> <% shipping-address2 %>

<%% if.survey[] %%>アンケート： <% survey[] %><%% endif %%>

TEXT;


// OznForm 実行ファイル読み込み
require '../../ozn-form.php';

?>


<!-- 送信完了画面のHTMLをここから下に記述する。特定ページへリダイレクトする場合は省略可。 -->



<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ozn-Form - サンプルフォーム</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <?php echo $ozn_form_styles; ?>
    <link rel="stylesheet" href="../css/sample_form_style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Ozn-Form</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li class="active"><a href="#contact">サンプルフォーム</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <h1>
            お問い合わせ
            <small>送信完了</small>
        </h1>

        <div class="row">
            <p class="col-sm-12 text-center">
                <a href="/document/sample_form/" class="btn btn-success">フォームトップへ戻る</a>
            </p>
        </div>
    </div>
</div>