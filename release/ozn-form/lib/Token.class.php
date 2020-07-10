<?php

namespace OznForm;

class Token
{
    const TOKEN_KEY = '_token';
    private $token;

    /**
     * トークンを生成する
     */
    public function make()
    {
        $this->token = bin2hex(openssl_random_pseudo_bytes(24));
        return $this;
    }

    /**
     * トークンをセッションに保存
     */
    public function setSession()
    {
        $_SESSION[self::TOKEN_KEY] = $this->token;
        return $this;
    }

    /**
     * セッションに保存してあるトークンをinput#hiddenタグに書き出す
     */
    public function csrfTag()
    {
        return '<input type="hidden" name="'.self::TOKEN_KEY.'" value="'.$this->token.'">';
    }

    /**
     * トークン文字列を返す
     * @return mixed
     */
    public function csrfToken()
    {
        return $this->token;
    }

    /**
     * トークンチェック
     * @param $token
     * @return boolean
     */
    public static function check($token)
    {
        return $_SESSION[self::TOKEN_KEY] === $token;
    }
}
