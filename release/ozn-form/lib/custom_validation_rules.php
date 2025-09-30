<?php
namespace OznForm\lib;

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
 * 電話番号検証（日本の電話番号形式）
 * 
 * - 数字部分が9-11桁であること（ハイフン等を除く）
 * - 国際電話形式（+付き）は不可
 */
\Valitron\Validator::addRule('tel', function($field, $value, array $params, array $fields) {
    // 空文字列またはnullの場合のみtrueを返す（"0"は空ではない）
    if ($value === '' || $value === null) {
        return TRUE;
    }
    
    // 全角文字を半角に変換
    $value = mb_convert_kana($value, 'n', 'UTF-8');
    
    // 国際電話形式（+で始まる）を除外
    if (preg_match('/^\+/', $value)) {
        return false;
    }
    
    // 許可された文字のみで構成されていることを確認
    if (!preg_match('/^[0-9\-ー−－‐()（）\s]+$/u', $value)) {
        return false;
    }
    
    // 数字のみを抽出
    $digits = preg_replace('/[^0-9]/', '', $value);
    
    // 数字が9桁以上11桁以下であることを確認
    $digit_count = strlen($digits);
    if ($digit_count < 9 || $digit_count > 11) {
        return false;
    }
    
    return true;
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
 * メールアドレス詳細（@が複数ある）
 */
\Valitron\Validator::addRule('email_atmark_over', function($field, $value, array $params, array $fields) {

    if(empty($value))
    {
        return TRUE;
    }
    else
    {
        return mb_substr_count($value, '@') <= 1;
    }
}, "に「@」マークが複数含まれています。");


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


/**
 *  フォームの値が指定値のいずれかと同じ（主に検証条件に使用）
 *  複数の値は | で区切って指定 (例: "value1|value2|value3")
 */
\Valitron\Validator::addRule('equals_any_value', function($field, $value, array $params, array $fields) {
    $allowedValues = explode('|', $params[0]);
    return in_array($value, $allowedValues);
}, "は指定されたいずれかの値である必要があります。");


/**
 *  フォームの値が指定文字列を部分的に含む（主に検証条件に使用）
 */
\Valitron\Validator::addRule('partial_match_value', function($field, $value, array $params, array $fields) {
    // 空の値の場合は true を返す（検証条件では空の場合は条件不成立として扱う）
    if (empty($value)) {
        return true;
    }
    return mb_strpos($value, $params[0]) !== false;
}, "は「%s」を含む必要があります。");
