<?php namespace OznForm;

// 「ひらがな」「カタカナ」のみ検証
\Valitron\Validator::addRule('kanaOnly', function($field, $value, array $params, array $fields) {
    return preg_match("/^[ぁ-んァ-ヶー　 ]+$/u", $value) ? true : false;
}, "は「ひらがな」か「カタカナ」で入力してください");


// 電話番号検証
\Valitron\Validator::addRule('tel', function($field, $value, array $params, array $fields) {
    return preg_match("/^[-ー−0-9０-９（）\(\)\s]{9,}$/u", $value) ? true : false;
}, "は市外局番を含む数字とハイフンの組み合わせで入力してください");

/**
 * 郵便番号検証
 *
 * 数字３桁・４桁・７桁（ハイフン含む）のとき検証OK
 */
\Valitron\Validator::addRule('zip', function($field, $value, array $params, array $fields) {
    return preg_match("/^\d{3}$|^\d{4}$|^\d{3}[\x{30FC}\x{2010}-\x{2015}\x{2212}\x{FF70}-]{0,1}\d{4}$/u", $value) ? true : false;
}, "の書式が違います。");