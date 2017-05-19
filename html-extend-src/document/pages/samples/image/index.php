<!-- @@master ../../../layout/sample.html {"title": "画像添付", "relative_path": "../../", "image_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'image.json';


// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';

?>

<!-- @@close -->

<!-- @@block content -->

    <div class="page-header">
        <h1>お問い合わせ</h1>
    </div>

    <form action="confirm.php" method="post">

        <!--ファイルアップロード-->
        <div class="row">
            <div class="form-group col-sm-6" data-oznform-fileup="attachment1[]"></div>
            <div class="form-group col-sm-6" data-oznform-fileup="attachment2[]"></div>
        </div>

        <hr>

        <div class="row actions">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-info">入力内容確認</button>
            </div>
        </div>
    </form>

<!-- @@close -->