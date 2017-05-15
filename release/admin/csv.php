<?php namespace OznForm;

require_once dirname(__FILE__) . '/../lib/MailHistory.class.php';

// DBクラスを読み込み
try{
    $history = new MailHistory();
}
catch (FormError $e)
{
    showLoginMessage($e->getMessage());
    exit();
}

if(strtolower($_SERVER['REQUEST_METHOD']) === 'post')
{

    // 未入力
    if( ! ($_POST['id'] && $_POST['password']))
    {
        showTemplate('ログインに失敗しました。<br>ID/パスワードを確認してください。');
    }

    if( ! $history->allowCSVDownload($_POST['id'], $_POST['password']))
    {
        showTemplate('ログインに失敗しました。<br>ID/パスワードを確認してください。');
    }


    if( ! $history->getCSV($_POST['form_name']))
    {
        showTemplate('出力データがありません。');
    }

}
else
{
    showTemplate();
}


/**
 * ログイン画面にエラーメッセージを表示して終了
 *
 * @param $message
 */
function showLoginMessage($message)
{
    showTemplate($message);
    exit();
}


/**
 * ログインフォームのテンプレート
 * @param string $error_message
 */
function showTemplate($error_message = '')
{
    echo <<<HTML

    <!doctype html>

    <html lang="ja">
    <head>
        <meta charset="utf-8">

        <title>OanForm - CSVダウンロード</title>
        <meta name="description" content="The HTML5 Herald">
        <meta name="author" content="SitePoint">

        <link rel="stylesheet" href="css/login.css">
    </head>

    <body>
        <div class="form-wrapper">
            <h1>Ozn Form</h1>
            <form method="post">
                <div class="form-item">
                    <label for="email"></label>
                    <input type="text" name="id" required="required" placeholder="管理者ID">
                </div>
                <div class="form-item">
                    <label for="password"></label>
                    <input type="password" name="password" required="required" placeholder="パスワード">
                </div>
                <div class="form-item">
                    <label for="form_name"></label>
                    <input type="text" name="form_name" required="required" placeholder="フォーム名">
                </div>
                <div class="errors">{$error_message}</div>
                <div class="button-panel">
                    <input type="submit" class="button" title="Sign In" value="CSVダウンロード">
                </div>
            </form>
            <div class="form-footer"></div>
        </div>

<!--    <script src="js/scripts.js"></script>-->
    </body>
    </html>

HTML;

}