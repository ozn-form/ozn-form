<?php namespace OznForm;

require dirname(__FILE__) . '/lib/MailSender.class.php';
require dirname(__FILE__) . '/lib/FormConfig.class.php';

var_dump(basename($_SERVER['PHP_SELF']));

var_dump(dirname(__FILE__));

$config = new FormConfig($config_path);


session_name($config->form_name);
session_start();

$mail_sender = new MailSender;
