<?php namespace OznForm;

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../lib/custom_validation_rules.php";

/**
 * Test new validation rules: equals_any_value and partial_match_value
 */

echo "=== Testing equals_any_value rule ===\n";

// Test 1: Should pass - value matches one of the allowed values
$params1 = array('material' => 'りんごパイ');
$v1 = new \Valitron\Validator($params1);
$v1->rule('equals_any_value', 'material', 'りんごパイ|りんごジャム');
$result1 = $v1->validate();
echo "Test 1 (りんごパイ matches りんごパイ|りんごジャム): " . ($result1 ? "PASS" : "FAIL") . "\n";
if (!$result1) {
    var_dump($v1->errors());
}

// Test 2: Should pass - value matches second allowed value  
$params2 = array('material' => 'りんごジャム');
$v2 = new \Valitron\Validator($params2);
$v2->rule('equals_any_value', 'material', 'りんごパイ|りんごジャム');
$result2 = $v2->validate();
echo "Test 2 (りんごジャム matches りんごパイ|りんごジャム): " . ($result2 ? "PASS" : "FAIL") . "\n";
if (!$result2) {
    var_dump($v2->errors());
}

// Test 3: Should fail - value doesn't match any allowed values
$params3 = array('material' => 'いちごジャム');
$v3 = new \Valitron\Validator($params3);
$v3->rule('equals_any_value', 'material', 'りんごパイ|りんごジャム');
$result3 = $v3->validate();
echo "Test 3 (いちごジャム doesn't match りんごパイ|りんごジャム): " . ($result3 ? "FAIL" : "PASS") . "\n";

// Test 4: Should pass - single value (backward compatibility test)
$params4 = array('material' => 'その他');
$v4 = new \Valitron\Validator($params4);
$v4->rule('equals_any_value', 'material', 'その他');
$result4 = $v4->validate();
echo "Test 4 (その他 matches その他 - single value): " . ($result4 ? "PASS" : "FAIL") . "\n";

echo "\n=== Testing partial_match_value rule ===\n";

// Test 5: Should pass - value contains substring
$params5 = array('material' => 'りんごパイ');
$v5 = new \Valitron\Validator($params5);
$v5->rule('partial_match_value', 'material', 'りんご');
$result5 = $v5->validate();
echo "Test 5 (りんごパイ contains りんご): " . ($result5 ? "PASS" : "FAIL") . "\n";

// Test 6: Should pass - value contains substring  
$params6 = array('material' => 'りんごジャム');
$v6 = new \Valitron\Validator($params6);
$v6->rule('partial_match_value', 'material', 'りんご');
$result6 = $v6->validate();
echo "Test 6 (りんごジャム contains りんご): " . ($result6 ? "PASS" : "FAIL") . "\n";

// Test 7: Should fail - value doesn't contain substring
$params7 = array('material' => 'いちごジャム');
$v7 = new \Valitron\Validator($params7);
$v7->rule('partial_match_value', 'material', 'りんご');
$result7 = $v7->validate();
echo "Test 7 (いちごジャム doesn't contain りんご): " . ($result7 ? "FAIL" : "PASS") . "\n";

// Test 8: Should pass - empty value (validation conditions should pass for empty values)
$params8 = array('material' => '');
$v8 = new \Valitron\Validator($params8);
$v8->rule('partial_match_value', 'material', 'りんご');
$result8 = $v8->validate();
echo "Test 8 (empty value with partial_match_value): " . ($result8 ? "PASS" : "FAIL") . "\n";

echo "\n=== Testing backward compatibility with existing equals_value rule ===\n";

// Test 9: Ensure existing equals_value still works
$params9 = array('material' => 'その他');
$v9 = new \Valitron\Validator($params9);
$v9->rule('equals_value', 'material', 'その他');
$result9 = $v9->validate();
echo "Test 9 (equals_value backward compatibility): " . ($result9 ? "PASS" : "FAIL") . "\n";

echo "\nAll tests completed.\n";