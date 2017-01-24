<?php

    // 設定ファイルのパスを設定
    $config_path = dirname(__FILE__) . '/' . 'sample_form1.json';

    // OznForm 実行ファイル読み込み
    require '../../ozn-form.php';

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
    <?php echo $ozn_form_styles; ?>

    <link rel="stylesheet" href="/document/css/sample_form_style.css">

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
        <h1>お問い合わせ</h1>
    </div>

    <form action="confirm.php" method="post">

        <div class="row">

            <div class="col-sm-4">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="title" id="title1" value="業務内容について" checked>
                        業務内容について
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="title" id="title2" value="採用について">
                        採用について
                    </label>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="title" id="title3" value="その他">
                        その他
                    </label>
                </div>
            </div>
        </div>


        <hr>

        <div class="form-group">
            <label for="mail_body">お問い合わせ詳細<span class="required">（必須）</span></label>
            <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <hr>

        <div class="row">

            <div class="form-group col-sm-5">
                <label for="customer_name">お名前<span class="required">（必須）</span></label>
                <input type="text" name="customer_name" class="form-control" id="customer_name" data-autoruby="customer_name" placeholder="例）田中 一郎">
            </div>
            <div class="form-group col-sm-5">
                <label for="customer_kana">ふりがな</label>
                <input type="text" name="customer_kana" class="form-control" id="customer_kana" data-autoruby-katakana="customer_name" placeholder="例）たなか いちろう">
            </div>

        </div>

        <div class="row">
            <div class="form-group col-sm-3 col-xs-6">
                <label for="zip-code">郵便番号<span class="required">（必須）</span></label>
                <input type="text" name="zip-code" id="zip-code" class="form-control" placeholder="例）432-3332" data-oznform-zip="addr1">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-7">
                <label for="address1">住所１（番地まで）<span class="required">（必須）</span></label>
                <input type="text" name="address1" id="address1" class="form-control" data-oznform-address="addr1" placeholder="例）愛知県名古屋市中村区11-1">
            </div>
            <div class="form-group col-sm-5">
                <label for="address2">住所２（建物名など）</label>
                <input type="text" name="address2" id="address2" class="form-control" placeholder="例）第一ビル 5F">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <label for="tel">電話番号</label>
                <input type="text" name="tel" id="tel" class="form-control" placeholder="例）1333-31-3234">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-8">
                <label for="email">メールアドレス<span class="required">（必須）</span></label>
                <input data-domain-suggest="true" type="text" name="email" id="email" class="form-control" placeholder="例）xxxx@gmail.jp">
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="form-group col-sm-4 materials">
                <label for="materials">資料送付<span class="required">（必須）</span></label>
                <select name="materials" id="materials" class="form-control">
                    <option value="">選択してください</option>
                    <option value="資料A">資料A</option>
                    <option value="資料B">資料B</option>
                    <option value="資料C">資料C</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="shipping-date">希望配送日</label>
                <input type="text" name="shipping-date" id="shipping-date" class="form-control" data-of_datepicker="true">
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-12 col-xs-12 form-inline shipping-zip-area">
                <label for="shipping-zip-code1">郵便番号<span class="required">（必須）</span></label><br>
                <input type="text" name="shipping-zip-code1" id="shipping-zip-code1" class="form-control" placeholder="例）432" data-oznform-zip="address2"> -
                <input type="text" name="shipping-zip-code2" id="shipping-zip-code2" class="form-control" placeholder="例）3332" data-oznform-zip="address2">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-7">
                <label for="address1">住所１（番地まで）<span class="required">（必須）</span></label>
                <input type="text" name="shipping-address1" id="shipping-address1" class="form-control" data-oznform-address="address2" placeholder="例）愛知県名古屋市中村区11-1">
            </div>
            <div class="form-group col-sm-5">
                <label for="address2">住所２（建物名など）</label>
                <input type="text" name="shipping-address2" id="shipping-address2" class="form-control" placeholder="例）第一ビル 5F">
            </div>
        </div>

        <hr>

        <div class="row">
            <h5 class="col-sm-12">アンケート<span class="required">（必須）</span></h5>
            <div class="ozn-check col-sm-12 surveys" style="text-indent: 0.5em;">
                <label class="checkbox-inline">
                    <input name="survey[]" type="checkbox" value="<b>項目1"> 項目1
                </label>
                <label class="checkbox-inline">
                    <input name="survey[]" type="checkbox" value="項目2"> 項目2
                </label>
                <label class="checkbox-inline">
                    <input name="survey[]" type="checkbox" value="項目3"> 項目3
                </label>
                <label class="checkbox-inline">
                    <input name="survey[]" type="checkbox" value="項目4"> 項目4
                </label>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <input id="fileupload" type="file" name="files[]" data-url="/js/jQuery-File-Upload-9.14.2/server/php/index.php" multiple>
            </div>
        </div>

        <hr>
        <div class="checkbox">
            <label class="ozn-check" style="text-indent: 1em;">
                <input name="privacy" type="checkbox"> 個人情報の取り扱いに同意する<span class="required">（必須）</span>
            </label>
        </div>

        <hr>

        <div class="row actions">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-info">確認画面へ</button>
            </div>
        </div>
    </form>

</div>





<!-- SCRIPTS -->
<!-- Example: <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
</body>
</html>
