<?php

// 設定ファイルのパスを設定
$config_path = __DIR__ . '/normal.json';

// OznForm 実行ファイル読み込み
require __DIR__ . '/../../release/ozn-form/ozn-form.php';

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ozn-form Documents - ノーマル</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!--    <link rel="stylesheet" href="/document/css/style.min.css">-->

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

<div class="page-header">
    <h1>お問い合わせサンプル（ノーマル版）</h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <p>
        このサンプルフォームでは、メールは <a href="http://localhost:8025">こちら</a>に送信されます。<br>
        
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
    <form action="confirm.php" method="post" aria-label="お問い合わせフォーム">

        <?php echo $oznFormToken->csrfTag(); ?>

        <div class="ozn-form-inner" role="table" aria-label="お問い合わせフォーム">
            <div class="tr" data-oznform-area="title" role="row">
                <div class="th" role="rowheader"><span id="title-label">お問い合わせ種別 <span class="ozn-label required">必須</span></span></div>
                <div class="td" role="cell">
                    <div class="ozn-check vertical" data-test-id="titleValid" role="radiogroup" aria-labelledby="title-label" aria-required="true">
                        <label>
                            <input type="radio" name="title" value="見積りのご依頼"> 見積りのご依頼
                        </label>
                        <label>
                            <input type="radio" name="title" value="商品に関するお問い合わせ" data-test-id="titleCheck"> 商品に関するお問い合わせ
                        </label>
                        <label>
                            <input type="radio" name="title" value="求人へのご応募"> 求人へのご応募
                        </label>
                        <label>
                            <input type="radio" name="title" value="その他のお問い合わせ"> その他のお問い合わせ
                        </label>
                    </div>
                    <div class="title-error" role="alert" aria-live="polite"></div>
                </div>
            </div>
            <div class="tr" data-oznform-area="customer_name" role="row">
                <div class="th" role="rowheader"><label for="customer_name">お名前 <span class="ozn-label required">必須</span></label></div>
                <div class="td" role="cell">
                    <input type="text" name="customer_name" class="ozn-input" id="customer_name" data-test-id="customerName" data-autoruby="customer_name" placeholder="例）山田 太郎" autocomplete="name" aria-required="true">
                </div>
            </div>
            <div class="tr" data-oznform-area="customer_kana" role="row">
                <div class="th" role="rowheader"><label for="customer_kana">フリガナ <span class="ozn-label required">必須</span></label></div>
                <div class="td" role="cell">
                    <input type="text" name="customer_kana" class="ozn-input" id="customer_kana" data-test-id="customerKana" data-autoruby-katakana="customer_name" placeholder="例）ヤマダ タロウ" autocomplete="" aria-required="true">
                </div>
            </div>
            <div class="tr" data-oznform-area="pref" role="row">
                <div class="th" role="rowheader"><span id="address-label">ご住所</span></div>
                <div class="td" role="cell">
                    <dl>
                        <dt><label for="zip-code">郵便番号 <span class="ozn-label optional">任意</span></label></dt>
                        <dd><input type="text" name="zip-code" id="zip-code" class="ozn-input pc-30 tb-50" style="ime-mode:inactive;" placeholder="例）432-3332" data-oznform-zip="address" autocomplete="postal-code">
                            <p class="ozn-notice">郵便番号を入力すると住所を自動で表示します</p></dd>
                    </dl>
                    <dl>
                        <dt><label for="pref">都道府県 <span class="ozn-label required">必須</span></label></dt>
                        <dd><input type="text" name="pref" id="pref" class="ozn-input pc-30 tb-50" placeholder="例）愛知県" data-oznform-pref="address" autocomplete="address-level1" aria-required="true">
                        </dd>
                    </dl>
                    <dl>
                        <dt><label for="address">番地まで <span class="ozn-label required">必須</span></label></dt>
                        <dd><input type="text" name="address" id="address" class="ozn-input" data-oznform-address="address" placeholder="例）名古屋市中村区＊＊町3丁目11-1" autocomplete="street-address" aria-required="true"></dd>
                    </dl>
                    <dl>
                        <dt><label for="address-building">建物名等 <span class="ozn-label optional">任意</span></label></dt>
                        <dd><input type="text" name="address-building" id="address-building" class="ozn-input" placeholder="例）＊＊ビル 201号室" autocomplete="address-level4"></dd>
                    </dl>
                </div>
            </div>
            <div class="tr" data-oznform-area="tel" role="row">
                <div class="th" role="rowheader"><label for="tel">電話番号 <span class="ozn-label required">必須</span></label></div>
                <div class="td" role="cell">
                    <input type="tel" name="tel" id="tel" class="ozn-input" style="ime-mode:inactive;" placeholder="例）000-111-2222" autocomplete="tel-national" aria-required="true" aria-describedby="tel-notice">
                    <p class="ozn-notice" id="tel-notice">日中にご連絡の取りやすい番号をご記入ください。</p>
                </div>
            </div>
            <div class="tr" data-oznform-area="email" role="row">
                <div class="th" role="rowheader"><label for="email">メールアドレス <span class="ozn-label required">必須</span></label></div>
                <div class="td" role="cell">
                    <div class="ozn-form-suggest-wrapper">
                        <input data-domain-suggest="true" type="text" inputmode="email" name="email" id="email" style="ime-mode:inactive;" class="ozn-input" placeholder="例）yamada@example.com" aria-required="true">
                    </div>
                </div>
            </div>
            <div class="tr" data-oznform-area="materials" role="row">
                <div class="th" role="rowheader"><label for="materials">興味のある商品 <span class="ozn-label optional">任意</span></label></div>
                <div class="td" role="cell">
                    <select name="materials" id="materials" class="ozn-input pc-50 tb-50" aria-describedby="materials-instruction">
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
                    <p id="materials-instruction">以下は「その他」を選んだ方のみ必須</p>
                    <dl>
                        <dt><label for="materials-etc">その他の商品名</label></dt>
                        <dd><input type="text" name="materials-etc" id="materials-etc" class="ozn-input" placeholder="例）マカロン"></dd>
                    </dl>
                </div>
            </div>
            <div class="tr" data-oznform-area="shipping-date" role="row">
                <div class="th" role="rowheader"><label for="shipping-date">ご希望納期 <span class="ozn-label optional">任意</span></label></div>
                <div class="td" role="cell">
                    <input type="text" name="shipping-date" id="shipping-date" class="ozn-input pc-50 tb-50" data-of_datepicker="true" placeholder="例）2017年10月10日"><br class=" visible-xs-inline">までに必要
                </div>
            </div>
            <div class="tr" data-oznform-area="mail_body" role="row">
                <div class="th" role="rowheader"><label for="mail_body">お問い合わせ内容 <span class="ozn-label required">必須</span></label></div>
                <div class="td" role="cell">
                    <textarea name="mail_body" id="mail_body" rows="10" class="ozn-input" placeholder="例）＊＊＊＊製品の見積希望" aria-required="true"></textarea>
                </div>
            </div>
            <div class="tr" data-oznform-area="survey[]" role="row">
                <div class="th" role="rowheader"><span id="survey-label">当社を何で知りましたか <span class="ozn-label required">必須</span></span></div>
                <div class="td" role="cell">
                    <div class="ozn-check horizontal" data-test-id="checkSurvey" role="group" aria-labelledby="survey-label" aria-required="true">
                        <label>
                            <input type="checkbox" name="survey[]" value="ウェブ検索"> ウェブ検索
                        </label>
                        <label>
                            <input type="checkbox" name="survey[]" value="チラシ"> チラシ
                        </label>
                        <label>
                            <input type="checkbox" name="survey[]" data-test-id="clickSurvey" value="看板"> 看板
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
