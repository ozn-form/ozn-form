<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $ex->getMessage() ?></title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <?= $ex->getMessage() ?><br>
    <a href="<?= $config->formRoot() ?>">フォームトップへ戻る</a>
</div>

</body>
</html>
