<?php

session_start();

setlocale(LC_ALL, 'ja_JP');

require('UploadHandler.php');

$upload_handler = new UploadHandler(array(

    'delete_type' => 'POST',

     // The regular expression for allowed file types, matches
     // against either file type or file name:
    'accept_file_types' => '/\.(gif|jpe?g|png|pdf|txt|xls|xlsx|doc|docx|zip)$/i',

     // The maximum allowed file size in bytes:
     'max_file_size' =>  2000000, // 2 MB

     // The limit of files to be uploaded:
     'max_number_of_files' => 10
));

