<!-- @@master ../../../layout/sample.html {"title": "画像添付", "relative_path": "../../", "image_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'image.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

?>
<!-- @@close -->

<!-- @@block content -->

<div class="page-header">
    <h1>画像添付フォームサンプル</h1>
</div>

<div class="ozn-form-stepbar-wrapper">
    <p>
        このサンプルフォームでは、送信完了まで操作できますが、実際にメールは送信されません。<br>
        送信テストまで行いたい方はこの同ディレクトリ内にある設定ファイルと送信完了画面（メールテンプレート）を修正してください。
    </p>
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
        <div class="tr" data-if="customer_name">
            <div class="th">お名前 <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_name"></span></div>
        </div>
        <div class="tr" data-if="customer_kana">
            <div class="th">フリガナ <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="customer_kana"></span></div>
        </div>
        <div class="tr" data-if="email">
            <div class="th">メールアドレス <span class="ozn-label required">必須</span></div>
            <div class="td"><span data-insert="email"></span></div>
        </div>
        <div class="tr" data-if="attachment1[]">
            <div class="th">添付ファイル１ <span class="ozn-label required">必須</span></div>
            <div class="td"><div data-insert="attachment1[]"></div></div>
        </div>
    </div>

    <div class="ozn-form-buttons">
        <span><a href="./complete.php" class="ozn-btn ozn-form-nav submit">この内容で送信する →</a></span>
        <span><a href="./index.php" class="ozn-btn ozn-form-nav back">← 戻って書き直す</a></span>
    </div>

</div><!-- ozn-form-inner -->



<!-- @@close -->
