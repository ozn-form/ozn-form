<?php
namespace OznForm\lib\exceptions;

use Exception;

class FormError extends Exception
{

    // 例外を再定義し、メッセージをオプションではなくする
    public function __construct($message, $code = 0, Exception $previous = null) {

        parent::__construct($message, $code, $previous);
    }
}