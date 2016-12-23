<?php namespace OznForm;


class FromUtility
{

    /**
     * 現在のページ名を返す
     *
     * @note 呼び出し元ファイル名をページ名として定義している
     *
     * @param array $backtrace <debug_backtrace()の結果配列>
     *
     * @return string <ページ名>
     */
    public function currentPageName($backtrace) {
        return preg_replace('/\..+$/', '', basename($backtrace[0]["file"]));
    }
}