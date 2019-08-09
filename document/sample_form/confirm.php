<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'sample_form1.json';

// OznForm 実行ファイル読み込み
require_once '../../release/ozn-form.php';

?>

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

    <link rel="stylesheet" href="../css/sample_form_style.css">
    <?php echo $ozn_form_styles; ?>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
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
                <small>入力内容確認</small>
            </h1>
        </div>

        <div class="row">
            <p class="col-sm-12">
               下記の内容で送信します。間違いありませんか？
            </p>
        </div>

        <form action="complete.php" method="post" enctype="multipart/form-data">
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
                        <tr data-if="tel">
                            <th>電話番号</th>
                            <td data-insert="tel"></td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td data-insert="email"></td>
                        </tr>
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
                <div class="col-sm-12">

                    <h4>資料送付について</h4>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th width="30%">資料タイプ</th>
                            <td width="70%" data-insert="materials"></td>
                        </tr>
                        <tr>
                            <th>送付先 ご住所</th>
                            <td>
                                〒<span data-insert="shipping-zip-code1"></span>-<span data-insert="shipping-zip-code2"></span><br>
                                <span data-insert="shipping-address1"></span> <span data-insert="shipping-address2"></span>
                            </td>
                        </tr>
                        <tr data-if="survey[]">
                            <th>アンケート</th>
                            <td data-insert="survey[]"></td>
                        </tr>
                        <tr data-if="privacy">
                            <th>個人情報の取扱について</th>
                            <td>同意いただいています。</td>
                        </tr>

                    </table>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="index.php" class="btn btn-info ozn-form-nav">戻る</a>
                    <button type="submit" class="btn btn-success ozn-form-nav ozn-form-send" data-message="ただいま送信中です。">上記内容で送信する</button>
                </div>
            </div>
            <?php echo $oznFormToken->csrfTag(); ?>
        </form>
    </div>

</body>
</html>
