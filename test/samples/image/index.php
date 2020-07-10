
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'image.json';


// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ozn-form Documents - 画像添付</title>
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
        <li><a href="../../guidance/config_file.html">設定ファイルの書き方</a></li>
        <li><a href="../../guidance/form_template.html">フォームテンプレートの書き方</a></li>
        <li><a href="../../guidance/mail_template.html">メールテンプレートの書き方</a></li>
    </ul>
</li>


<li class="dropdown ">
    <a href="../../" class="dropdown-toggle" id="functions_drop" data-toggle="dropdown"
       role="button"
       aria-haspopup="true" aria-expanded="true"> 機能説明 <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="functions_drop">
        <li><a href="../../functions/styles.html">標準スタイル設定</a></li>
    </ul>
</li>

<li class="dropdown ">
    <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button"
       aria-haspopup="true" aria-expanded="true"> サンプルフォーム <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="drop1">
        <li class="">
            <a href="../../samples/normal/?mail_body=これはテスト送信です。">ノーマル版</a>
        </li>
        <li class="">
            <a href="../../samples/no_confirm/">確認画面なし</a></li>
        <!--<li class="&lt;!&ndash; @@var= step_active &ndash;&gt;">-->
            <!--<a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/step/">ステップ分割</a>-->
        <!--</li>-->
        <li class="active">
            <a href="../../samples/image/">画像添付</a>
        </li>
    </ul>
</li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

<div class="page-header">
    <h1>画像添付フォームサンプル</h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <p>
        このサンプルフォームでは、送信完了まで操作できますが、実際にメールは送信されません。<br>
        送信テストまで行いたい方はこの同ディレクトリ内にある設定ファイルと送信完了画面（メールテンプレート）を修正してください。
    </p>
    <ol class="ozn-form-stepbar step3 hidden-xs">
        <li class="current">1. 内容の入力</li>
        <li>2. 内容確認</li>
        <li>3. 送信完了</li>
    </ol>
    <ol class="ozn-form-stepbar step3 visible-xs-block">
        <li class="current">入力</li>
        <li>確認</li>
        <li>完了</li>
    </ol>
</div>

<div class="ozn-form-container">
    <form action="confirm.php" method="post">

        <div class="ozn-form-inner">

            <div class="tr" data-oznform-area="customer_name">
                <div class="th">お名前 <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <input type="text" name="customer_name" class="ozn-input" id="customer_name" data-autoruby="customer_name" placeholder="例）山田 太郎" autocomplete="name">
                </div>
            </div>
            <div class="tr" data-oznform-area="customer_kana">
                <div class="th">フリガナ <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <input type="text" name="customer_kana" class="ozn-input" id="customer_kana" data-autoruby-katakana="customer_name" placeholder="例）ヤマダ タロウ" autocomplete="">
                </div>
            </div>
            <div class="tr" data-oznform-area="email">
                <div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <div class="ozn-form-suggest-wrapper">
                        <input data-domain-suggest="true" type="email" name="email" style="ime-mode:inactive;" class="ozn-input" placeholder="例）yamada@example.com">
                    </div>
                </div>
            </div>
            <div class="tr">
                <div class="th">画像の添付 <span class="ozn-label optional">任意</span></div>
                <div class="td">
                    <div class="ozn-file-block" data-oznform-fileup="attachment1[]"></div>
                    <p class="ozn-notice">※送信可能な形式：gif, png, jpg, pdf, txt, xls, xlsx, doc, docx, zip <br>
                        ※2MBを超えるサイズのデータは送信できません。</p>
                </div>
            </div>
        </div>

        <div class="ozn-form-buttons">
            <button type="submit" class="ozn-btn ozn-form-nav submit">入力内容の確認へ進む →</button>
        </div>

    </form>
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
