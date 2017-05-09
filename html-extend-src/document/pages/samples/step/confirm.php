<!-- @@master ../../../layout/sample.html {"title": "シンプル", "relative_path": "../../", "simple_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'step.json';

// OznForm 実行ファイル読み込み
require_once '../../../release/ozn-form.php';

?>
<!-- @@close -->

<!-- @@block content -->

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
            <tr>
                <th>メールアドレス</th>
                <td data-insert="email"></td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 text-center">
        <a href="complete.php" class="btn btn-success ozn-form-send" data-message="送信中です…">上記内容で送信する</a>
        <a href="step2.php" class="btn btn-info">戻る</a>
    </div>
</div>



<!-- @@close -->