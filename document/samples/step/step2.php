<!-- start php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'step.json';


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
        <h1>お問い合わせ</h1>
    </div>

    <form action="confirm.php" method="post">

        <div class="row">
            <div class="form-group col-sm-5" data-oznform-area="customer_name">
                <label for="customer_name">お名前<span class="required">（必須）</span></label>
                <input type="text" name="customer_name" class="form-control" id="customer_name" data-autoruby="customer_name" placeholder="例）田中 一郎">
            </div>
            <div class="form-group col-sm-5" data-oznform-area="customer_kana">
                <label for="customer_kana">ふりがな</label>
                <input type="text" name="customer_kana" class="form-control" id="customer_kana" data-autoruby-katakana="customer_name" placeholder="例）たなか いちろう">
            </div>
        </div>

        <div class="row" data-oznform-area="zip-code">
            <div class="form-group col-sm-3 col-xs-6">
                <label for="zip-code">郵便番号<span class="required">（必須）</span></label>
                <input type="text" name="zip-code" id="zip-code" class="form-control" placeholder="例）432-3332" data-oznform-zip="addr1">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-7" data-oznform-area="address1">
                <label for="address1">住所１（番地まで）<span class="required">（必須）</span></label>
                <input type="text" name="address1" id="address1" class="form-control" data-oznform-address="addr1" placeholder="例）愛知県名古屋市中村区11-1">
            </div>
            <div class="form-group col-sm-5" data-oznform-area="address2">
                <label for="address2">住所２（建物名など）</label>
                <input type="text" name="address2" id="address2" class="form-control" placeholder="例）第一ビル 5F">
            </div>
        </div>


        <div class="row" data-oznform-area="email">
            <div class="form-group col-sm-8">
                <label for="email">メールアドレス<span class="required">（必須）</span></label>
                <input data-domain-suggest="true" type="text" name="email" id="email" class="form-control" placeholder="例）xxxx@gmail.jp">
            </div>
        </div>

        <div class="row actions">
            <div class="col-sm-6">
                <a href="./index.php" class="btn btn-info">戻る</a>
                <button type="submit" class="btn btn-success">入力内容確認</button>
            </div>
        </div>
    </form>


<!-- end content -->
</div>
</body>
</html>
