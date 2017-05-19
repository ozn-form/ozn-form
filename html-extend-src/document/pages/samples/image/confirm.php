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



<!-- @@close -->