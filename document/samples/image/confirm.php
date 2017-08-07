<!-- start php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'image.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

?>

<!-- end php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ozn-Form Document - 画像添付</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="../..//css/style.min.css">

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
            <a class="navbar-brand" href="#">Ozn-Form Document</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<!-- start _header.html-->
<li class=""><a href="../../">ホーム</a></li>

<li class="dropdown ">
    <a href="#" class="dropdown-toggle" id="functions_drop" data-toggle="dropdown" role="button"
       aria-haspopup="true" aria-expanded="true"> 機能説明 <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="functions_drop">
        <li><a href="../../functions/setting.html">設定一覧</a></li>
        <li><a href="../../functions/sub_setting.html">補助機能</a></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="true"> サンプルフォーム <span class="caret"></span> </a>
    <ul class="dropdown-menu" aria-labelledby="drop1">
        <li class=""><a href="../../samples/simple/">シンプル</a></li>
        <li class=""><a href="../../samples/no_confirm/">確認スキップ</a></li>
        <li class=""><a href="../../samples/step/">ステップ</a></li>
        <li class="active"><a href="../../samples/image/">画像添付</a></li>
    </ul>
</li>

<!-- end _header.html-->
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<!-- start content -->
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
                <th>添付ファイル１</th>
                <td data-insert="attachment1[]"></td>
            </tr>
            <tr>
                <th>添付ファイル２</th>
                <td data-insert="attachment2[]"></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-center">
        <a href="complete.php" class="btn btn-success ozn-form-send" data-message="送信中です…">上記内容で送信する</a>
        <a href="index.php" class="btn btn-info">戻る</a>
    </div>
</div>




<!-- end content -->
</div>
</body>
</html>
