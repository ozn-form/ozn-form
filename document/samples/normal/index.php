
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'normal.json';

// OznForm 実行ファイル読み込み
require __DIR__ . '../../../../release/ozn-form.php';

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
        <li class="active">
            <a href="../../samples/normal/?mail_body=これはテスト送信です。">ノーマル版</a>
        </li>
        <li class="">
            <a href="../../samples/no_confirm/">確認画面なし</a></li>
        <!--<li class="&lt;!&ndash; @@var= step_active &ndash;&gt;">-->
            <!--<a href="&lt;!&ndash;@@var= relative_path &ndash;&gt;samples/step/">ステップ分割</a>-->
        <!--</li>-->
        <li class="">
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
    <h1>お問い合わせサンプル（ノーマル版）</h1>
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
            <div class="tr" data-oznform-area="title">
                <div class="th">お問い合わせ種別 <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <div class="ozn-check vertical">
                        <label>
                            <input type="radio" name="title" value="見積りのご依頼"> 見積りのご依頼
                        </label>
                        <label>
                            <input type="radio" name="title" value="商品に関するお問い合わせ"> 商品に関するお問い合わせ
                        </label>
                        <label>
                            <input type="radio" name="title" value="求人へのご応募"> 求人へのご応募
                        </label>
                        <label>
                            <input type="radio" name="title" value="その他のお問い合わせ"> その他のお問い合わせ
                        </label>
                    </div>
                    <div class="title-error"></div>
                </div>
            </div>
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
            <div class="tr" data-oznform-area="pref">
                <div class="th">ご住所</div>
                <div class="td">
                    <dl>
                        <dt>郵便番号 <span class="ozn-label optional">任意</span></dt>
                        <dd><input type="text" name="zip-code" class="ozn-input pc-30 tb-50" style="ime-mode:inactive;" placeholder="例）432-3332" data-oznform-zip="address" autocomplete="postal-code">
                            <p class="ozn-notice">郵便番号を入力すると住所を自動で表示します</p></dd>
                    </dl>
                    <dl>
                        <dt>都道府県 <span class="ozn-label required">必須</span></dt>
                        <dd><input name="pref" class="ozn-input pc-30 tb-50" placeholder="例）愛知県" data-oznform-pref="address" autocomplete="address-level1">
                        </dd>
                    </dl>
                    <dl>
                        <dt>番地まで <span class="ozn-label required">必須</span></dt>
                        <dd><input type="text" name="address" class="ozn-input" data-oznform-address="address" placeholder="例）名古屋市中村区＊＊町3丁目11-1" autocomplete="street-address"></dd>
                    </dl>
                    <dl>
                        <dt>建物名等 <span class="ozn-label optional">任意</span></dt>
                        <dd><input type="text" name="address-building" class="ozn-input" placeholder="例）＊＊ビル 201号室" autocomplete="address-level4"></dd>
                    </dl>
                </div>
            </div>
            <div class="tr" data-oznform-area="tel">
                <div class="th">電話番号 <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <input type="tel" name="tel" class="ozn-input" style="ime-mode:inactive;" placeholder="例）000-111-2222" autocomplete="tel-national">
                    <p class="ozn-notice">日中にご連絡の取りやすい番号をご記入ください。</p>
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
            <div class="tr" data-oznform-area="materials">
                <div class="th">興味のある商品 <span class="ozn-label optional">任意</span></div>
                <div class="td">
                    <select name="materials" class="ozn-input pc-50 tb-50">
                        <option value="">お選びください</option>
                        <optgroup label="お菓子">
                            <option value="ケーキ">ケーキ</option>
                            <option value="クッキー">クッキー</option>
                            <option value="チョコレート">チョコレート</option>
                        </optgroup>
                        <optgroup label="ドリンク">
                            <option value="コーヒー">コーヒー</option>
                            <option value="紅茶">紅茶</option>
                            <option value="オレンジジュース">オレンジジュース</option>
                        </optgroup>
                        <option value="その他">その他</option>
                    </select>
                    <p>以下は「その他」を選んだ方のみ必須</p>
                    <dl>
                        <dt>その他の商品名</dt>
                        <dd><input type="text" name="materials-etc" class="ozn-input" placeholder="例）マカロン"></dd>
                    </dl>
                </div>
            </div>
            <div class="tr" data-oznform-area="shipping-date">
                <div class="th">ご希望納期 <span class="ozn-label optional">任意</span></div>
                <div class="td">
                    <input type="text" name="shipping-date" class="ozn-input pc-50 tb-50" data-of_datepicker="true" placeholder="例）2017年10月10日"><br class=" visible-xs-inline">までに必要
                </div>
            </div>
            <div class="tr" data-oznform-area="mail_body">
                <div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <textarea name="mail_body" rows="10" class="ozn-input" placeholder="例）＊＊＊＊製品の見積希望"></textarea>
                </div>
            </div>
            <div class="tr" data-oznform-area="survey[]">
                <div class="th">当社を何で知りましたか <span class="ozn-label required">必須</span></div>
                <div class="td">
                    <div class="ozn-check horizontal">
                        <label>
                            <input type="checkbox" name="survey[]" value="ウェブ検索"> ウェブ検索
                        </label>
                        <label>
                            <input type="checkbox" name="survey[]" value="チラシ"> チラシ
                        </label>
                        <label>
                            <input type="checkbox" name="survey[]" value="看板"> 看板
                        </label>
                        <label>
                            <input type="checkbox" name="survey[]" value="その他"> その他
                        </label>
                    </div>
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
