
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'no_confirm.json';

// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';


?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ozn-form Documents - 確認画面なし</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
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
            <a class="navbar-brand" href="#">ozn-form Documents</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<li class=""><a href="../../">製品概要</a></li>

<!--<li class="dropdown &lt;!&ndash; @@var= functions_active &ndash;&gt;">-->
    <!--<a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;" class="dropdown-toggle" id="functions_drop" data-toggle="dropdown" role="button"-->
       <!--aria-haspopup="true" aria-expanded="true"> 機能説明 <span class="caret"></span> </a>-->
    <!--<ul class="dropdown-menu" aria-labelledby="functions_drop">-->
        <!--<li><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;functions/setting.html">設定一覧</a></li>-->
        <!--<li><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;functions/sub_setting.html">補助機能</a></li>-->
    <!--</ul>-->
<!--</li>-->

<!--<li class="dropdown">-->
    <!--<a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button"-->
                             <!--aria-haspopup="true" aria-expanded="true"> サンプルフォーム <span class="caret"></span> </a>-->
    <!--<ul class="dropdown-menu" aria-labelledby="drop1">-->
        <!--<li class="&lt;!&ndash; @@var= normal_active &ndash;&gt;"><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/normal/?mail_body=これはテスト送信です。">ノーマル版</a></li>-->
        <!--<li class="&lt;!&ndash; @@var= no_confirm_active &ndash;&gt;"><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/no_confirm/">確認スキップ</a></li>-->
        <!--<li class="&lt;!&ndash; @@var= step_active &ndash;&gt;"><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/step/">ステップ分割</a></li>-->
        <!--<li class="&lt;!&ndash; @@var= image_active &ndash;&gt;"><a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/image/">画像添付</a></li>-->
    <!--</ul>-->
<!--</li>-->

<li class=""><a href="../../samples/normal/?mail_body=これはテスト送信です。">サンプルフォーム</a></li>

<li><a href="../../../order-form/">導入希望はこちらから</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

<div class="container">

    <div class="page-header">
        <h1>
            確認画面なし
            <small>サンプルフォーム</small>
        </h1>
    </div>

    <form action="complete.php" method="post">

        <div class="row ozn-check" data-oznform-area="title">

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

        <hr data-oznform-area="title">

        <div class="form-group" data-oznform-area="mail_body">
            <label for="mail_body">お問い合わせ詳細<span class="required">（必須）</span></label>
            <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <hr data-oznform-area="mail_body">

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

        <hr>

        <div class="row" data-oznform-area="anq_other" style="margin-bottom: 1em;">

            <h4>アンケート</h4>
            <p style="margin-bottom: 2em;">このサイトを訪れたきっかけについて教えてください</p>

            <div class="ozn-check">
                <div class="col-sm-4">
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="anq" id="anq1" value="検索サイトなど" checked>
                            検索サイトなど
                        </label>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="anq" id="anq2" value="知人の紹介">
                            知人の紹介
                        </label>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="radio-inline">
                        <label>
                            <input type="radio" name="anq" id="anq3" value="その他">
                            その他
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-8">
                <label for="email">その他のきっかけ<span class="required">（「その他」を選択した場合は必須）</span></label>
                <input type="text" name="anq_other" id="anq_other" class="form-control">
            </div>
        </div>

        <hr>

        <div class="row actions">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-success ozn-form-send">すぐ送信</button>
<!--                <a href="#" class="btn btn-info ozn-form-nav">戻る</a>-->
            </div>
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
