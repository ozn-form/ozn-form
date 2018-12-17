
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'step.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ozn-form Documents - ステップ</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="../..css/style.min.css">

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
<<<<<<< HEAD
            <a class="navbar-brand" href="../..">ozn-form Document</a>
=======
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">ozn-form Documents</a>
>>>>>>> addDocuments
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">

<!-- ヘッダメニュー -->


<li class="">
    <a href="../..">製品概要</a>
</li>


<li class="dropdown ">
    <a href="../.." class="dropdown-toggle" id="guidance_drop" data-toggle="dropdown"
       role="button"
       aria-haspopup="true" aria-expanded="true"> 使い方 <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="guidance_drop">
        <li><a href="../..guidance/index.html">はじめに</a></li>
        <li><a href="../..guidance/config_file.html">設定ファイルの書き方</a></li>
        <li><a href="../..guidance/form_template.html">フォームテンプレートの書き方</a></li>
        <li><a href="../..guidance/mail_template.html">メールテンプレートの書き方</a></li>
    </ul>
</li>


<li class="dropdown ">
    <a href="../.." class="dropdown-toggle" id="functions_drop" data-toggle="dropdown"
       role="button"
       aria-haspopup="true" aria-expanded="true"> 機能説明 <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="functions_drop">
        <li><a href="../..functions/setting.html">設定一覧</a></li>
        <li><a href="../..functions/sub_setting.html">補助機能</a></li>
        <li><a href="../..functions/styles.html">標準スタイル設定</a></li>
    </ul>
</li>


            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

<div class="page-header">
    <h1>
        お問い合わせ
        <small>入力内容確認</small>
    </h1>
</div>

<div class="row">
    <p class="col-sm-12">
        下記の内容で送信します。間違いありませんか？
    </p>
</div>


<div class="row">

    <div class="col-sm-12">
        <h4>お客様情報</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <th width="30%">問い合わせ内容</th>
                <td width="70%" data-insert="title"></td>
            </tr>
            <tr>
                <th>問い合わせ詳細</th>
                <td data-insert="mail_body"></td>
            </tr>
            <tr>
                <th>お名前</th>
                <td>
                    <span data-insert="customer_name"></span>
                    <span data-if="customer_kana">
                            （<span data-insert="customer_kana"></span>）
                        </span>
            </tr>
            <tr>
                <th>ご住所</th>
                <td>
                    〒<span data-insert="zip-code"></span><br>
                    <span data-insert="address1"></span> <span data-insert="address2"></span>
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td data-insert="email"></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-center">
        <a href="complete.php" class="btn btn-success ozn-form-send" data-message="送信中です…">上記内容で送信する</a>
        <a href="step2.php" class="btn btn-info ozn-form-nav">戻る</a>
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
