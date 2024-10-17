<?php
namespace OznForm\lib;

class MailTemplate
{
    private $sys_info;
    private $params;

    function __construct($sys_info)
    {
        $this->sys_info = $sys_info;
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
     * @param string     $template
     *
     * @return string <パラメータ置換済みテンプレート>
     */
    public function output($template) {

        if(empty($template)) return $template;

        if($this->sys_info) $template = $this->replaceSystemTags($template);

        $template = $this->replaceTags($template);
        $template = $this->replaceIfTags($template);
        $template = $this->replaceHarSizeTags($template);


        return $template;

    }


    public function replaceSystemTags($template) {

        foreach ($this->sys_info as $key => $v) {

            // 送信日時(DateTime)を日付形式文字列に
            if($key === 'send_date') $v = $v->format('Y年m月d日 H:i');

            $template = preg_replace("/<%\s*\{$key\}\s*%>/", $v, $template);
        }

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
            $template = preg_replace("/<%\s*$key\s*%>/", $v ?? '', $template);
        }

        return $template;
    }


    /**
     * IFタグ置換
     * @param $template
     *
     * @return mixed
     */
    private function replaceIfTags($template) {
        return preg_replace_callback(
            "/<%%\s*if\.(.+?)\s*%%>(.+?)<%%\s*endif\s*%%>(\n{0,1})/s",

            function($matches) {

                if(isset($this->params[$matches[1]]) && $this->params[$matches[1]] !== '') {
                    return $matches[2].$matches[3];
                }
            }, $template);
    }


    /**
     * 半角カナタグ置換
     * @param $template
     *
     * @return mixed
     */
    private function replaceHarSizeTags($template) {
        return preg_replace_callback(
            "/<%%\s*halfsize\s*%%>(.*?)<%%\s*endhalfsize\s*%%>(\n{0,1})/s",

            function($matches) {

                $half = mb_convert_kana($matches[1], 'kh');
                return $half.$matches[2];
            }, $template);
    }


}