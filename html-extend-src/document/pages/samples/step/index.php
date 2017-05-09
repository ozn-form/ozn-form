<!-- @@master ../../../layout/sample.html {"title": "ステップ", "relative_path": "../..", "step_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'step.json';


// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';

?>

<!-- @@close -->

<!-- @@block content -->

    <div class="page-header">
        <h1> STEP1 - ステップフォーム
        <small>サンプルフォーム</small></h1>
    </div>

    <form action="step2.php" method="post">

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
        <hr>

        <div class="form-group" data-oznform-area="mail_body">
            <label for="mail_body">お問い合わせ詳細<span class="required">（必須）</span></label>
            <textarea name="mail_body" id="mail_body" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="row actions">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-success">STEP2 へ</button>
            </div>
        </div>
    </form>

<!-- @@close -->