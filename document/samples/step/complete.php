<!-- start php -->
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

<!-- end php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ozn-Form Sample - ステップ</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
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
            <a class="navbar-brand" href="#">Ozn-Form サンプル</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class=""><a href="/document/samples/simple/">シンプル</a></li>
                <li class=""><a href="/document/samples/no_confirm/">確認スキップ</a></li>
                <li class="active"><a href="/document/samples/step/">ステップ</a></li>
                <!--<li class="&lt;!&ndash; @@var= home_active &ndash;&gt;"><a href="#about">About</a></li>-->
                <!--<li class="active"><a href="#contact">サンプルフォーム</a></li>-->
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<!-- start content -->
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


<!-- end content -->
</div>
</body>
</html>
