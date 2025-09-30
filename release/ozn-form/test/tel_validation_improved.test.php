<?php namespace OznForm;

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../lib/custom_validation_rules.php";

echo "=== 電話番号バリデーション改善後のテスト ===\n\n";

$test_cases = array(
    // エラーになるべきケース（改善により修正される）
    '0' => false,                    // 1桁のみ
    '12345678' => false,             // 8桁のみ
    '+81-90-1234-5678' => false,     // 国際形式
    'abc123456789' => false,         // 英字を含む
    '12345678901234' => false,       // 14桁（長すぎ）
    
    // 通過するケース（既存の動作を維持 + テスト用途の000-000-0000も許可）
    '000-000-0000' => true,          // テスト用途で使用（ユーザーの要望により許可）
    '000000000' => true,             // 全て0でも9桁あれば許可
    '0000000000' => true,            // 全て0でも10桁あれば許可
    '1111111111' => true,            // 全て同じ数字でも許可
    '03-1234-5678' => true,          // 固定電話
    '0312345678' => true,            // ハイフンなし固定電話
    '090-1234-5678' => true,         // 携帯電話
    '09012345678' => true,           // ハイフンなし携帯電話
    '050-1234-5678' => true,         // IP電話
    '0120-123-456' => true,          // フリーダイヤル
    '(03)1234-5678' => true,         // 括弧付き
    '123456789' => true,             // 9桁
    '12345678901' => true,           // 11桁
);

$passed = 0;
$failed = 0;

foreach ($test_cases as $value => $expected) {
    $params = array('tel' => $value);
    $v = new \Valitron\Validator($params);
    $v->rule('tel', 'tel');
    $result = $v->validate();
    
    if ($result === $expected) {
        echo "✓ PASS: '{$value}' - " . ($expected ? "通過" : "エラー") . "\n";
        $passed++;
    } else {
        echo "✗ FAIL: '{$value}' (expected: " . 
             ($expected ? "通過" : "エラー") . 
             ", got: " . ($result ? "通過" : "エラー") . ")\n";
        if (!$result && !empty($v->errors())) {
            var_dump($v->errors());
        }
        $failed++;
    }
}

echo "\n結果: {$passed} passed, {$failed} failed\n";

if ($failed === 0) {
    echo "✓ すべてのテストが成功しました！\n";
    exit(0);
} else {
    echo "✗ {$failed} 件のテストが失敗しました\n";
    exit(1);
}
