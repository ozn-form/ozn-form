<!-- @@master ../../../layout/sample.html {"title": "ノーマル", "relative_path": "../../", "normal_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'normal.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

?>
<!-- @@close -->

<!-- @@block content -->

<div class="page-header">
    <h1>
        お問い合わせサンプル（ノーマル版）
        <small>入力内容確認</small>
    </h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <p>このサンプルフォームでは実際に送信でき、正しいメールアドレスを入れれば自動返信メールも受け取れます。<br>
        テスト送信されたメール内容は、当方ではチェックせずにゴミ箱に入る設定にしておりますが、気にする方は捨てアドレスをお使いください。また、メールアドレス以外の個人情報等の送信はしないでください。</p>
    <ol class="ozn-form-stepbar step3 hidden-xs">
        <li>1. 内容の入力</li>
        <li class="current">2. 内容確認</li>
        <li>3. 送信完了</li>
    </ol>
    <ol class="ozn-form-stepbar step3 visible-xs-block">
        <li>入力</li>
        <li class="current">確認</li>
        <li>完了</li>
    </ol>
</div>

<div class="ozn-form-container ozn-form-confirm">

    <div class="ozn-form-lead">
        <h2>ご入力内容の確認</h2>
        <p>下記の入力内容に間違いが無ければ、一番下の「この内容で送信する」ボタンを押し、送信を完了してください。</p>
    </div>

    <div class="ozn-form-inner">
        <div class="tr" data-if="title">
            <div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="title"></span></div>
        </div>
        <div class="tr" data-if="customer_name">
            <div class="th">お名前 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_name"></span></div>
        </div>
        <div class="tr" data-if="customer_kana">
            <div class="th">フリガナ <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_kana"></span></div>
        </div>
        <div class="tr">
            <div class="th">ご住所 <span class="ozn-label required">必須</span></div>
            <div class="td">
                <span data-if="zip-code">〒<span data-insert="zip-code"></span><br></span>
                <span data-insert="pref"></span><span data-insert="address"></span>
                <span data-if="address-building"><br><span data-insert="address-building"></span></span>
            </div>
        </div>
        <div class="tr" data-if="tel">
            <div class="th">電話番号 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="tel"></span></div>
        </div>
        <div class="tr" data-if="email">
            <div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="email"></span></div>
        </div>
        <div class="tr" data-if="materials">
            <div class="th">興味のある商品 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="materials"></span>
                <span data-if="materials-etc"><br>その他の商品名：<span data-insert="materials-etc"></span></span>
            </div>
        </div>
        <div class="tr" data-if="shipping-date">
            <div class="th">ご希望納期 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="shipping-date"></span>までに必要</div>
        </div>
        <div class="tr" data-if="mail_body">
            <div class="th">お問い合わせ内容 <span class="ozn-label required">必須</span></div>
            <div class="td"><div data-insert="mail_body"></div></div>
        </div>
        <div class="tr" data-if="survey[]">
            <div class="th">チェック項目 <span class="ozn-label optional">任意</span></div>
            <div class="td"><span data-insert="survey[]"></span></div>
        </div>
    </div>

    <div class="ozn-form-buttons">
        <span><a href="./complete.php" class="ozn-btn ozn-form-nav submit">この内容で送信する →</a></span>
        <span><a href="./index.php" class="ozn-btn ozn-form-nav back">← 戻って書き直す</a></span>
    </div>

</div><!-- ozn-form-inner -->

<!-- @@close -->
