<?php namespace OznForm;

use OznForm\lib\FormValidation;

require_once __DIR__ . '/lib/FormValidation.php';

$json = file_get_contents(__DIR__ . '/config/mobile_mail_address.json');
$address_list = json_decode($json,true);

$return_data = array(
    'valid'   => false,
    'warning' => null,
    'errors'  => null
);


if(isset($_POST['validate'])) {

    $postValue = isset($_POST['values']) ? $_POST['values'] : [$_POST['name'] => ''];

    $v = new FormValidation();

    $is_valid = $v->run(
        $_POST['name'],
        $postValue,
        $_POST['validate'],
        $_POST['label'],
        isset($_POST['condition']) ? $_POST['condition'] : null,
        isset($_POST['error_messages']) ? $_POST['error_messages'] : array()
    );

    $target_value = $postValue[$_POST['name']];

    if($is_valid) {

        $return_data['valid'] = true;

        // キャリアアドレスの場合、注意メッセージを設定
        if(isset($_POST['mobile_warning']) && (! empty($target_value))) {

            list($user, $domain) = explode('@', $target_value);

            if(in_array($domain, $address_list)) {
                $return_data['warning'] = array($_POST['mobile_warning']);
            }
        }

    } else {
        $return_data['errors'] = $v->errorMessages();
    }

    echo json_encode($return_data);

} else {

    // 検証なしの項目の場合は無条件に検証成功フラグを返す
    echo json_encode(array('valid' => true, 'errors' => null));
}
