<?php namespace OznForm;

// 「ひらがな」「カタカナ」のみ検証
\Valitron\Validator::addRule('kanaOnly', function($field, $value, array $params, array $fields) {
    return preg_match("/^[ぁ-んァ-ヶー　 ]+$/u", $value) ? true : false;
}, "は「ひらがな」か「カタカナ」で入力してください");


// 電話番号検証
\Valitron\Validator::addRule('tel', function($field, $value, array $params, array $fields) {
    return preg_match("/^[-ー−0-9０-９（）\(\)\s]{9,}$/u", $value) ? true : false;
}, "は市外局番を含む数字とハイフンの組み合わせで入力してください");