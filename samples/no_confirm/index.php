<?php

// 設定ファイルのパスを設定
$config_path = __DIR__ . '/no_confirm.json';

// OznForm 実行ファイル読み込み
require '../../release/ozn-form/ozn-form.php';


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

    <link rel="stylesheet" href="../../css/style.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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


<div class="container">

<div class="container">

    <div class="page-header">
        <h1>
            確認画面なし
            <small>サンプルフォーム</small>
        </h1>
    </div>

    <div class="ozn-form-stepbar-wrapper">
        <p>このサンプルは確認画面なしのすぐに送信するタイプの最小構成フォームになります。</p>
        <p>デモ用フォームですので、メール送信機能は無効化しています。</p>
        <ol class="ozn-form-stepbar step2 hidden-xs">
            <li class="current">1. 内容の入力</li>
            <li>2. 送信完了</li>
        </ol>
        <ol class="ozn-form-stepbar step2 visible-xs-block">
            <li class="current">入力</li>
            <li>完了</li>
        </ol>
    </div>


    <form action="complete.php" method="post">

        <div class="ozn-form-container">
            <div class="ozn-form-inner">

                <div class="tr">
                    <div class="th">お問い合わせ内容<span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <div class="ozn-check horizontal">
                            <label>
                                <input type="radio" name="title" id="title1" value="業務内容について">
                                業務内容について
                            </label>
                            <label>
                                <input type="radio" name="title" id="title2" value="採用について">
                                採用について
                            </label>
                            <label>
                                <input type="radio" name="title" id="title3" value="その他">
                                その他
                            </label>
                        </div>
                    </div>
                </div>

                <div class="tr">
                    <div class="th">お問い合わせ詳細<span class="ozn-label optional">任意</span></div>
                    <div class="td">
                        <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>


                <div class="tr">
                    <div class="th">お名前<span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <input type="text" name="customer_name" class="form-control" id="customer_name" data-autoruby="customer_name" placeholder="例）田中 一郎">
                    </div>
                </div>


                <div class="tr">
                    <div class="th">ふりがな<span class="ozn-label optional">任意</span></div>
                    <div class="td">
                        <input type="text" name="customer_kana" class="form-control" id="customer_kana" data-autoruby-katakana="customer_name" placeholder="例）たなか いちろう">
                    </div>
                </div>


                <div class="tr">
                    <div class="th">ご住所</div>
                    <div class="td">
                        <dl>
                            <dt>郵便番号<span class="ozn-label required">必須</span></dt>
                            <dd>
                                <input type="text" name="zip-code" class="ozn-input pc-30 tb-50" style="ime-mode:inactive;" placeholder="例）432-3332" data-oznform-zip="address" autocomplete="postal-code">
                                <p class="ozn-notice">郵便番号を入力すると住所を自動で表示します</p></dd>
                            </dd>
                        </dl>
                        <dl>
                            <dt>住所<span class="ozn-label required">必須</span></dt>
                            <dd><input type="text" name="address1" class="ozn-input" data-oznform-address="address" placeholder="例）名古屋市中村区＊＊町3丁目11-1" autocomplete="street-address"></dd>
                        </dl>
                        <dl>
                            <dt>建物名等 <span class="ozn-label optional">任意</span></dt>
                            <dd><input type="text" name="address2" class="ozn-input" placeholder="例）＊＊ビル 201号室" autocomplete="address-level4"></dd>
                        </dl>
                    </div>
                </div>

                <div class="tr">
                    <div class="th">メールアドレス<span class="ozn-label required">必須</span></div>
                    <div class="td">
                        <input data-domain-suggest="true" type="text" inputmode="email" name="email" id="email" class="form-control" placeholder="例）xxxx@gmail.jp">
                    </div>
                </div>

            </div>


            <div class="ozn-form-buttons">
                <span><a href="complete.php" class="ozn-btn ozn-form-nav submit ozn-form-send">この内容で送信する →</a></span>
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
