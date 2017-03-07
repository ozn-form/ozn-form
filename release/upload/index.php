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
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => '添付ファイルのサイズが大きすぎます',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'このファイル形式は送信できません',
        'max_number_of_files' => 'Maximum number of files exceeded',
        'max_width' => 'Image exceeds maximum width',
        'min_width' => 'Image requires a minimum width',
        'max_height' => 'Image exceeds maximum height',
        'min_height' => 'Image requires a minimum height',
        'abort' => 'File upload aborted',
        'image_resize' => 'Failed to resize image'
));

