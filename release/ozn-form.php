<?php namespace OznForm;

require_once dirname(__FILE__) . '/lib/MailSender.class.php';
require_once dirname(__FILE__) . '/lib/FormConfig.class.php';
require_once dirname(__FILE__) . '/lib/FormError.class.php';
require_once dirname(__FILE__) . '/lib/FromUtility.class.php';

/**
 * フォームファイルへ書き出す js タグを生成
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

// ページ設定チェック
if(!isset($config_path)) {
    throw new FormError('設定ファイルパスが記載されていません。');
}

$config = new FormConfig($config_path);
$util   = new FromUtility();

/**
 * 環境情報（パスなど）を定義
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$system_root = dirname(__FILE__);   // OznFormシステムのルートパス
$page_name   = $util->currentPageName(debug_backtrace());
$forms       = $config->pageForms($page_name);
$page_role   = $config->pageRole($page_name);



// ToDo: ルートパス以外に設置した時のテストを実施する
// ルートパスからの相対パスを取得する
$document_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $system_root);
if($document_path) {$document_path = '/' . $document_path;}



/**
 * 書き出し用 js タグを生成
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

if($forms) {
    $forms_json = json_encode($forms);
} else {
    $forms_json = '{}';
}

// <head>に出力するscriptタグを設定
$ozn_form_scripts = <<<HTML

    <script type="application/javascript">
        OznForm = {};
        OznForm.page_role = "$page_role";
        OznForm.vurl  = "$document_path/ozn-form-validation.php";
        OznForm.forms = $forms_json;
    </script>
    <script src="$document_path/js/ozn-form-init.js"></script>

HTML;

/**
 * 書き出し用 css タグを生成
 * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
 */

$ozn_form_styles = <<<HTML
        <link rel="stylesheet" href="$document_path/css/ozn-form-style.css">
HTML;



session_name($config->formName());
session_start();;

