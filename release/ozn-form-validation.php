<?php namespace OznForm;

require dirname(__FILE__) . '/vendor/autoload.php';

// エラーメッセージの設定
use Valitron\Validator as V;

V::langDir(__DIR__.'/vendor/vlucas/valitron/lang'); // always set langDir before lang.
V::lang('ja');


$return_data = array(
    'valid' => false,
    'errors' => null
);

//var_dump($_POST);

if(isset($_POST['validate'])) {

    $v = new \Valitron\Validator(array($_POST['name'] => $_POST['value']));

    foreach ($_POST['validate'] as $validate) {
        if (isset($_POST['error_messages']) && isset($_POST['error_messages'][$validate])) {
            $v->rule($validate, $_POST['name'])->message($_POST['error_messages'][$validate]);
        } else {
            $v->rule($validate, $_POST['name'])->label($_POST['label']);
        }
    }

    if($v->validate()) {
        $return_data['valid'] = true;
    } else {
        $return_data['errors'] = $v->errors();
    }

    echo json_encode($return_data);

} else {
    echo json_encode(array('valid' => true, 'errors' => null));
}

