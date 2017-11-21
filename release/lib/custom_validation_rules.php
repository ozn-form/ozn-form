<?php namespace OznForm;

/**
 * 「ひらがな」「カタカナ」のみ検証
 */
\Valitron\Validator::addRule('kanaOnly', function($field, $value, array $params, array $fields) {
    if(empty($value))
    {
        return TRUE;
    }
    else {
        return preg_match("/^[ぁ-んァ-ヶー　 ]+$/u", $value) ? TRUE : FALSE;
    }
}, "は「ひらがな」か「カタカナ」で入力してください");


/**
 * 電話番号検証
 */
\Valitron\Validator::addRule('tel', function($field, $value, array $params, array $fields) {
    if(empty($value))
    {
        return TRUE;
    }
    else
    {
        return preg_match("/^[-ー−0-9０-９（）\(\)\s]{9,}$/u", $value) ? true : false;
    }
}, "は市外局番を含む数字またはハイフンの組み合わせで入力してください");

/**
 * 郵便番号検証
 *
 * 数字３桁・４桁・７桁（ハイフン含む）のとき検証OK
 */
\Valitron\Validator::addRule('zip', function($field, $value, array $params, array $fields) {

    if(empty($value))
    {
        return TRUE;
    }
    else
    {
        return preg_match("/^\d{3}$|^\d{4}$|^\d{3}[\x{30FC}\x{2010}-\x{2015}\x{2212}\x{FF70}-]{0,1}\d{4}$/u", $value) ? true : false;
    }
}, "の書式が違います。");



/**
 * メールアドレス詳細（@がない場合）
 */
\Valitron\Validator::addRule('email_atmark', function($field, $value, array $params, array $fields) {

    if(empty($value))
    {
        return TRUE;
    }
    else
    {
        return preg_match("/@/", $value);
    }
}, "に「@」マークが含まれていません");


/**
 * メールアドレス詳細（@より前がない）
 */
\Valitron\Validator::addRule('email_no_user', function($field, $value, array $params, array $fields) {

    if(empty($value) || ( ! preg_match("/@/", $value)))
    {
        return TRUE;
    }
    else
    {
        list($user, $domain) = explode('@', $value);

        return preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+$/", $user);
    }
}, "の「@」より前が正しくないようです。確認の上再度ご入力ください。");


/**
 * メールアドレス詳細（@より後ろが不正確）
 */
\Valitron\Validator::addRule('email_domain', function($field, $value, array $params, array $fields) {

    if(empty($value) || ( ! preg_match("/@/", $value)))
    {
        return TRUE;
    }
    else
    {
        list($user, $domain) = explode('@', $value);

        return  preg_match("/^([a-zA-Z0-9_-])+(\.[a-zA-Z0-9\._-]+)+$/", $domain);
    }
}, "の「@」以降が正しくないようです。確認の上再度ご入力ください。");

/**
 * メールアドレス詳細（ドットがカンマ）
 */
\Valitron\Validator::addRule('email_comma', function($field, $value, array $params, array $fields) {

    if(empty($value) || ( ! preg_match("/@/", $value)))
    {
        return TRUE;
    }
    else
    {
        return !preg_match("/,/", $value);
    }
}, "の「.（ドット）」が「,（カンマ）」になっていませんか？");


/**
 *  フォームの値が指定値と同じ（主に検証条件に使用）
 */
\Valitron\Validator::addRule('equals_value', function($field, $value, array $params, array $fields) {
    return $value === $params[0];
}, "は「%s」と同じ値である必要があります。");


/**
 *  チェックボックス（複数）の値が指定値を含む（主に検証条件に使用）
 */
\Valitron\Validator::addRule('included', function($field, $value, array $params, array $fields) {

    if(is_array($value)) {
        return in_array($params[0], $value);
    } else {
        return $value === $params[0];
    }
}, "は「%s」を含む必要があります。");


/**
 *  送信値（配列）の数がxx以上
 */
\Valitron\Validator::addRule('itemCountGreaterThan', function($field, $value, array $params, array $fields) {

    if(is_array($value)) {
        return count($value) >= $params[0];
    } else {
        return 1 >= $params[0];
    }
}, "は%sつ以上選択してください。");


/**
 *  送信値（配列）の数がxx以下
 */
\Valitron\Validator::addRule('itemCountLessThan', function($field, $value, array $params, array $fields) {

    if(is_array($value)) {
        return count($value) <= $params[0];
    } else {
        return 1 <= $params[0];
    }
}, "は%sつ以下で選択してください。");
