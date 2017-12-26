<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'ozn-config.json';


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
$admin_mail_title = 'ozn-form <% title %> 希望';

// 管理者宛メールテンプレート
$admin_mail_body = <<< TEXT
Webサイトから下記の内容でお問い合わせがありました。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<■ご希望の導入方法： <% title %><%% if.corporate_name %%>
■企業名・団体名： <% corporate_name %><%% endif %%><%% if.corporate_kana %%>
■企業名・団体名フリガナ： <% corporate_kana %><%% endif %%>
■ご担当者様氏名： <% customer_name %>
■ご担当者様フリガナ： <% customer_kana %>
■メールアドレス： <% email %><%% if.mail_body %%>
■お問い合わせ詳細： <% mail_body %><%% endif %%>

- - - - - - - - - - - - - - - - - - - - - - - - -
送信シリアルNo：<% {serial} %>
送信元エージェント：<% {user_agent} %>
参照元：<% {referrer} %>
送信日時：<% {send_date} %>

TEXT;


// 自動返信メールの設定（送信しない場合は必要なし）
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - //

// 自動返信メールタイトル
$customer_mail_title = '＊＊＊へのお問合せありがとうございます';

// 自動返信メールテンプレート
$customer_mail_body = <<< TEXT
<%% if.corporate_name %%><% corporate_name %>
<%% endif %%><% customer_name %>様

ozn-form設置に関するお問い合わせ、ありがとうございます。
担当者が内容を確認し、改めて納品手順・お支払い方法等の確認をさせていただきますのでお待ちください。

- - - - - - - - - - - - - - - - - - - - - - - - - - -
<■ご希望の導入方法： <% title %><%% if.corporate_name %%>
■企業名・団体名： <% corporate_name %><%% endif %%><%% if.corporate_kana %%>
■企業名・団体名フリガナ： <% corporate_kana %><%% endif %%>
■ご担当者様氏名： <% customer_name %>
■ご担当者様フリガナ： <% customer_kana %>
■メールアドレス： <% email %><%% if.mail_body %%>
■お問い合わせ詳細： <% mail_body %><%% endif %%>


================
ozone notes
https://www.ozonenotes.jp/

TEXT;

// OznForm 実行ファイル読み込み
require '../release/ozn-form.php';

//送信完了画面のHTMLをここから下に記述する。特定ページへリダイレクトする場合は省略可。
?>
<!DOCTYPE html>
<html>
<head>
<title>ozn-form 導入についてのお問い合わせ - STEP03</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width">
<?php echo $ozn_form_styles; ?>
<link rel="stylesheet" href="./css/style.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>

<?php include('./inc/header.php'); ?>

<div class="container">

    <div class="page-header">
        <h1>導入についてのお問い合わせ</h1>
    </div>

    <div class="ozn-form-stepbar-wrapper">
        <ol class="ozn-form-stepbar step3 sp-hide">
            <li>1. 内容の入力</li>
            <li>2. 内容確認</li>
            <li class="current">3. 送信完了</li>
        </ol>
        <ol class="ozn-form-stepbar step3 tb-hide pc-hide">
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
            <p>&raquo;<a href="/" title="HOME">トップページへ戻る</a></p>
        </div>

    </div>

</div>

<?php include('./inc/footer.php'); ?>

</body>
</html>