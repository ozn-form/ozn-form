<?php

return array(

    // フォーム管理者ID（変更必須）
    'oznform_admin_id' => 'admin',

    // フォーム管理者PASS（変更必須）
    'oznform_admin_pass' => 'test',

    // データベース
    'database' => 'sqlite',

    // データベースパス
    // ※ releaseディレクトリからの相対パスで記載（最後の / は必須）
    // ※ 設定したディレクトリは事前に作成し書き込み権限を付与しておくこと
    'database_path' => 'db/',

    // SQLite の設定
    'sqlite' => array(

        // データベース名（推測しにくい文字列で変更推奨）
        // ここのファイル名を変更した場合は release/db/sample_jpj5405WD94E3GTvgG5wet459gsGjgHGee.db も変更してください。
        'db_name' => 'sample_jpj5405WD94E3GTvgG5wet459gsGjgHGee'
    ),
);