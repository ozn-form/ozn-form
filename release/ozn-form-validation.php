<?php namespace OznForm;

require_once dirname(__FILE__) . '/vendor/autoload.php';

require_once dirname(__FILE__) . '/lib/custom_validation_rules.php';

// エラーメッセージの設定
use Valitron\Validator as V;

V::langDir(__DIR__.'/vendor/vlucas/valitron/lang'); // always set langDir before lang.
V::lang('ja');


$json = file_get_contents(dirname(__FILE__) . '/config/mobile_mail_address.json');
$address_list = json_decode($json,true);

$return_data = array(
    'valid'   => false,
    'warning' => null,
    'errors'  => null
);


if(isset($_POST['validate'])) {

    $value = (isset($_POST['value']) ? $_POST['value'] : '');

    $v = new \Valitron\Validator(array($_POST['name'] => $value));


    foreach ($_POST['validate'] as $validate) {
        if (isset($_POST['error_messages']) && isset($_POST['error_messages'][$validate])) {
            $v->rule($validate, $_POST['name'])->message($_POST['error_messages'][$validate]);
        } else {
            $v->rule($validate, $_POST['name'])->label($_POST['label']);
        }
    }

    if($v->validate()) {

        $return_data['valid'] = true;

        // キャリアアドレスの場合、注意メッセージを設定
        if(isset($_POST['mobile_warning'])) {

            list($user, $domain) = explode('@', $value);

            if(in_array($domain, $address_list)) {
                $return_data['warning'] = array($_POST['mobile_warning']);
            }
        }

    } else {
        $return_data['errors'] = $v->errors();
    }

    echo json_encode($return_data);

} else {
    echo json_encode(array('valid' => true, 'errors' => null));
}

