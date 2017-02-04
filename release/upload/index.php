<?php

session_start();

setlocale(LC_ALL, 'ja_JP');

require('UploadHandler.php');

$upload_handler = new UploadHandler(array(
    'delete_type' => 'POST'
));

