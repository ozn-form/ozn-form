<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $ex->getMessage() ?></title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        <!--
        #container {
            text-align: center;
            margin-top: 150px;
            line-height: 2em;
        }
        -->
    </style>
</head>

<body>

<div id="container">
    <p><?= $ex->getMessage() ?></p>
    <p>この画面が表示される場合、入力データの形式が正しくない、または必須入力欄が空のまま送信ボタンが押された、などの理由が考えられえます。<br>
    お手数ですが、前の画面へ戻って入力のやり直しをお願いします。</p>
    <p><a href="<?= $config->formRoot() ?>">お問い合わせフォームへ戻る</a></p>
</div>

</body>
</html>
