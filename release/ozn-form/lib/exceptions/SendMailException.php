<?php
namespace OznForm\lib\exceptions;

/**
 * @property  bool isAdminMail
 */
class SendMailException extends \Exception
{
    
    private $isAdminMail;

    // 例外を再定義し、メッセージをオプションではなくする
    public function __construct($adminMailFlag, $message, $code = 0, \Exception $previous = null) {

        parent::__construct($message, $code, $previous);
        $this->isAdminMail = $adminMailFlag;

    }

    public function isAdminMail()
    {
        return $this->isAdminMail;
    }
}