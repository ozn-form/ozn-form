<?php

return array(

    // フォーム管理者ID（変更必須）
    'oznform_admin_id' => '',

    // フォーム管理者PASS（変更必須）
    'oznform_admin_pass' => '',

    // データベース
    'database' => 'sqlite',

    // データベースパス
    // ※ ozn-form.phpからの相対パスで記載（最後の / は必須）
    // ※ 設定したディレクトリは事前に作成し書き込み権限を付与しておくこと
    'database_path' => 'db/',

    // SQLite の設定
    'sqlite' => array(

        // データベース名（推測しにくい文字列で変更推奨）
        'db_name' => 'oznform_jgreaj5405WD94E3GTvgG5wet459gsGjge'
    ),

    /**
     * オプション設定
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     */

    // ダウンロード画面タイトル
    'adminPageTitle' => 'CSVダウンロード',

    // フォーム名選択
    'isMultiFormDataDownload' => true,

    // 削除ボタンを表示する
    'showDeleteBtn' => true,
);