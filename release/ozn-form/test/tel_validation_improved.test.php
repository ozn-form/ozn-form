<?php namespace OznForm;

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../lib/custom_validation_rules.php";

echo "=== 電話番号バリデーション改善後のテスト ===\n\n";

$test_cases = array(
    // エラーになるべきケース
    array('input' => '0',                'expected' => false), // 1桁のみ
    array('input' => '12345678',         'expected' => false), // 8桁のみ
    array('input' => '+81-90-1234-5678', 'expected' => false), // 国際形式
    array('input' => 'abc123456789',     'expected' => false), // 英字を含む
    array('input' => '12345678901234',   'expected' => false), // 14桁（長すぎ）

    // 通過するケース（既存の動作を維持 + テスト用途の000-000-0000も許可）
    array('input' => '000-000-0000',     'expected' => true),  // テスト用途で使用（ユーザーの要望により許可）
    array('input' => '000000000',        'expected' => true),  // 全て0でも9桁あれば許可
    array('input' => '0000000000',       'expected' => true),  // 全て0でも10桁あれば許可
    array('input' => '1111111111',       'expected' => true),  // 全て同じ数字でも許可
    array('input' => '03-1234-5678',     'expected' => true),  // 固定電話
    array('input' => '0312345678',       'expected' => true),  // ハイフンなし固定電話
    array('input' => '090-1234-5678',    'expected' => true),  // 携帯電話
    array('input' => '09012345678',      'expected' => true),  // ハイフンなし携帯電話
    array('input' => '050-1234-5678',    'expected' => true),  // IP電話
    array('input' => '0120-123-456',     'expected' => true),  // フリーダイヤル
    array('input' => '(03)1234-5678',    'expected' => true),  // 括弧付き
    array('input' => '123456789',        'expected' => true),  // 9桁
    array('input' => '12345678901',      'expected' => true),  // 11桁
);

$passed = 0;
$failed = 0;

foreach ($test_cases as $case) {
    $value    = $case['input'];
    $expected = $case['expected'];
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
