<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'normal.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

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

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="../../">ozn-form Document</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

<!-- ヘッダメニュー -->


<li class="">
    <a href="../../">製品概要</a>
</li>


<li class="dropdown ">
    <a href="../../" class="dropdown-toggle" id="guidance_drop" data-toggle="dropdown"
       role="button"
       aria-haspopup="true" aria-expanded="true"> 使い方 <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="guidance_drop">
        <li><a href="../../guidance/index.html">はじめに</a></li>
        <li><a href="../../guidance/flow.html">ファイル内容説明・設置手順</a></li>
        <li><a href="../../guidance/config_file.html">設定ファイルの書き方</a></li>
        <li><a href="../../guidance/form_template.html">フォームテンプレートの書き方</a></li>
        <li><a href="../../guidance/mail_template.html">メールテンプレートの書き方</a></li>
        <li><a href="../../guidance/styles.html">標準スタイル設定</a></li>
    </ul>
</li>



            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

<div class="page-header">
    <h1>
        お問い合わせサンプル（ノーマル版）
        <small>入力内容確認</small>
    </h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <p>このサンプルフォームでは実際に送信でき、正しいメールアドレスを入れれば自動返信メールも受け取れます。<br>
        テスト送信されたメール内容は、当方ではチェックせずにゴミ箱に入る設定にしておりますが、気にする方は捨てアドレスをお使いください。また、メールアドレス以外の個人情報等の送信はしないでください。</p>
    <ol class="ozn-form-stepbar step3 hidden-xs">
        <li>1. 内容の入力</li>
        <li class="current">2. 内容確認</li>
        <li>3. 送信完了</li>
    </ol>
    <ol class="ozn-form-stepbar step3 visible-xs-block">
        <li>入力</li>
        <li class="current">確認</li>
        <li>完了</li>
    </ol>
</div>

<div class="ozn-form-container ozn-form-confirm">

    <div class="ozn-form-lead">
        <h2>ご入力内容の確認</h2>
        <p>下記の入力内容に間違いが無ければ、一番下の「この内容で送信する」ボタンを押し、送信を完了してください。</p>
    </div>

    <div class="ozn-form-inner">
        <div class="tr" data-if="title">
            <div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="title"></span></div>
        </div>
        <div class="tr" data-if="customer_name">
            <div class="th">お名前 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_name"></span></div>
        </div>
        <div class="tr" data-if="customer_kana">
            <div class="th">フリガナ <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_kana"></span></div>
        </div>
        <div class="tr">
            <div class="th">ご住所 <span class="ozn-label required">必須</span></div>
            <div class="td">
                <span data-if="zip-code">〒<span data-insert="zip-code"></span><br></span>
                <span data-insert="pref"></span><span data-insert="address"></span>
                <span data-if="address-building"><br><span data-insert="address-building"></span></span>
            </div>
        </div>
        <div class="tr" data-if="tel">
            <div class="th">電話番号 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="tel"></span></div>
        </div>
        <div class="tr" data-if="email">
            <div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="email"></span></div>
        </div>
        <div class="tr" data-if="materials">
            <div class="th">興味のある商品 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="materials"></span>
                <span data-if="materials-etc"><br>その他の商品名：<span data-insert="materials-etc"></span></span>
            </div>
        </div>
        <div class="tr" data-if="shipping-date">
            <div class="th">ご希望納期 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="shipping-date"></span>までに必要</div>
        </div>
        <div class="tr" data-if="mail_body">
            <div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
            <div class="td"><div data-insert="mail_body"></div></div>
        </div>
        <div class="tr" data-if="survey[]">
            <div class="th">チェック項目 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="survey[]"></span></div>
        </div>
    </div>

    <div class="ozn-form-buttons">
        <span><a href="./complete.php" class="ozn-btn ozn-form-nav submit">この内容で送信する →</a></span>
        <span><a href="./index.php" class="ozn-btn ozn-form-nav back">← 戻って書き直す</a></span>
    </div>

</div><!-- ozn-form-inner -->


</div>

<hr class="setting-hr">
<footer>
    <div class="container">
        <p>&copy; ozone notes / 西三河情報システム</p>
    </div>
</footer>

</body>
</html>
