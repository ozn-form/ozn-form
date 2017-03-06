<?php namespace OznForm;

class MailTemplate
{
    private $params;

    function __construct()
    {
    }

    /**
     * 置換用パラメータをセット
     * @param $params
     */
    public function setParams($params) {
        $this->params = $params;
    }

    /**
     * 置換後のテンプレートを出力
     *
     * @param $template
     *
     * @return string <パラメータ置換済みテンプレート>
     */
    public function output($template) {

        $template = $this->replaceTags($template);
        $template = $this->replaceIfTags($template);

        return $template;

    }


    /**
     * テンプレートタグをパラメータで置換
     * @param $template
     *
     * @return mixed
     */
    private function replaceTags($template) {

        foreach ($this->params as $key => $v) {
            if(is_array($v)) {$v = join('、', $v);}
            $key = preg_quote($key);
            $template = preg_replace("/<%\s*$key\s*%>/", $v, $template);
        }

        return $template;
    }


    private function replaceIfTags($template) {
        return preg_replace_callback(
            "/<%%\s*if\.(.+?)\s*%%>(.+?)<%%\s*endif\s*%%>(\n{0,1})/s",

            function($matches) {

                if($this->params[$matches[1]]) {
                    return $matches[2].$matches[3];
                }
            }, $template);
    }


}