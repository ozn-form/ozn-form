<!-- @@master ../../../layout/sample.html {"title": "確認画面なし", "relative_path": "../../", "no_confirm_active":"active"} -->
<!-- @@block php -->
<?php

// 設定ファイルのパスを設定
$config_path = dirname(__FILE__) . '/' . 'no_confirm.json';

// OznForm 実行ファイル読み込み
require '../../../release/ozn-form.php';


?>
<!-- @@close -->

<!-- @@block content -->

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


<!-- @@close -->