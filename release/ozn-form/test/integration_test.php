<?php namespace OznForm;

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../lib/FormValidation.php";
require dirname(__FILE__) . "/../lib/FormConfig.php";

use OznForm\lib\FormValidation;
use OznForm\lib\FormConfig;

echo "=== Integration Test for New Validation Rules ===\n";

// Create FormConfig instance with the sample config file
$config = new FormConfig(dirname(__FILE__) . '/sample_config_new_rules.json');

// Create FormValidation instance  
$validator = new FormValidation();

echo "\n--- Test Case 1: りんごパイ selected (should trigger multiple value validation) ---\n";
$post_data1 = array(
    'materials' => 'りんごパイ',
    'materials-etc-multiple' => '', // This should fail validation because it's required when materials = りんごパイ
    'materials-etc-partial' => 'Added some りんご notes', // This should pass
    'materials-etc-original' => '' // This should pass (not triggered)
);

$result1 = $validator->validatePageForm('index', $post_data1, $config);
echo "Validation result: " . ($result1 ? "PASS" : "FAIL") . "\n";
if (!$result1) {
    echo "Errors:\n";
    foreach ($validator->errorMessages() as $field => $errors) {
        echo "  $field: " . implode(', ', $errors) . "\n";
    }
}

echo "\n--- Test Case 2: りんごジャム selected (should trigger both multiple value and partial match validation) ---\n";
$validator2 = new FormValidation();
$post_data2 = array(
    'materials' => 'りんごジャム',
    'materials-etc-multiple' => 'Some notes', // This should pass
    'materials-etc-partial' => 'More りんご details', // This should pass  
    'materials-etc-original' => '' // This should pass (not triggered)
);

$result2 = $validator2->validatePageForm('index', $post_data2, $config);
echo "Validation result: " . ($result2 ? "PASS" : "FAIL") . "\n";
if (!$result2) {
    echo "Errors:\n";
    foreach ($validator2->errorMessages() as $field => $errors) {
        echo "  $field: " . implode(', ', $errors) . "\n";
    }
}

echo "\n--- Test Case 3: いちごジャム selected (should not trigger any validation) ---\n";
$validator3 = new FormValidation();
$post_data3 = array(
    'materials' => 'いちごジャム',
    'materials-etc-multiple' => '', // This should pass (not triggered)
    'materials-etc-partial' => '', // This should pass (not triggered)
    'materials-etc-original' => '' // This should pass (not triggered)
);

$result3 = $validator3->validatePageForm('index', $post_data3, $config);
echo "Validation result: " . ($result3 ? "PASS" : "FAIL") . "\n";
if (!$result3) {
    echo "Errors:\n";
    foreach ($validator3->errorMessages() as $field => $errors) {
        echo "  $field: " . implode(', ', $errors) . "\n";
    }
}

echo "\n--- Test Case 4: その他 selected (should trigger original equals_value validation) ---\n";
$validator4 = new FormValidation();
$post_data4 = array(
    'materials' => 'その他',
    'materials-etc-multiple' => '', // This should pass (not triggered)
    'materials-etc-partial' => '', // This should pass (not triggered)  
    'materials-etc-original' => '' // This should fail (triggered but empty)
);

$result4 = $validator4->validatePageForm('index', $post_data4, $config);
echo "Validation result: " . ($result4 ? "PASS" : "FAIL") . "\n";
if (!$result4) {
    echo "Errors:\n";
    foreach ($validator4->errorMessages() as $field => $errors) {
        echo "  $field: " . implode(', ', $errors) . "\n";
    }
}

echo "\nIntegration tests completed.\n";