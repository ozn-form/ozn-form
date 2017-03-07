<?php

session_start();

setlocale(LC_ALL, 'ja_JP');

require('UploadHandler.php');

$upload_handler = new UploadHandler(

    array(

        'delete_type' => 'POST',

         // The regular expression for allowed file types, matches
         // against either file type or file name:
        'accept_file_types' => '/\.(gif|jpe?g|png|pdf|txt|xls|xlsx|doc|docx|zip)$/i',

         // The maximum allowed file size in bytes:
         'max_file_size' =>  2000000, // 2 MB

         // The limit of files to be uploaded:
         'max_number_of_files' => 10
    ),

    TRUE,

    array(
        1 => '添付ファイルのサイズが、ウェブサーバで許可された容量（upload_max_filesize）を超えています。縮小してから添付してください。',
        2 => '添付ファイルのサイズが、メールフォームで許可された容量（MAX_FILE_SIZE）を超えています。縮小してから添付してください。',
        3 => '添付ファイルのうち、一部のみしかアップロードできませんでした。',
        4 => '添付ファイルをアップロードできませんでした。',
        6 => '添付ファイルの一時保存用フォルダがありません。管理者にお問い合わせください。',
        7 => '添付ファイルをサーバ上に保存できませんでした。管理者にお問い合わせください。',
        8 => 'PHPの拡張モジュールがファイルのアップロードを中止しました。管理者にお問い合わせください。',
        'post_max_size' => '添付ファイルのサイズが、ウェブサーバで許可された容量（post_max_size）を超えています。縮小してから添付してください。',
        'max_file_size' => '添付ファイルのサイズが大きすぎます。縮小してから添付してください。',
        'min_file_size' => '添付ファイルのサイズが小さすぎます。',
        'accept_file_types' => 'このファイル形式は添付できません。',
        'max_number_of_files' => '添付ファイルの数が多すぎます。',
        'max_width' => '画像の横幅が制限サイズを超えています。縮小してから添付してください。',
        'min_width' => '画像の横幅が足りません。',
        'max_height' => '画像の高さが制限サイズを超えています。縮小してから添付してください。',
        'min_height' => '画像の高さが足りません。',
        'abort' => 'ファイル添付ができませんでした。管理者にお問い合わせください。',
        'image_resize' => '画像サイズの自動調整ができませんでした。管理者にお問い合わせください。'
));

