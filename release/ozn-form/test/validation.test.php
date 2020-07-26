<?php namespace OznForm;

require dirname(__FILE__) . "/../release/vendor/autoload.php";
require dirname(__FILE__) . "/../release/lib/custom_validation_rules.php";


call_user_func(function(){

    $params = array(
        '正常系テスト' => 'ふりがな',
        '漢字交じりテスト' => '振りがな'
    );

    $v = new \Valitron\Validator($params);

    $v->rule('kanaOnly', array_keys($params));
    $v->validate();
    var_dump($v->errors());
});

