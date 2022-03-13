<?php

namespace YLibs\Utility;

/**
 * 文字列操作クラス
 */
class YString
{

    /**
     * 文字列の末尾が指定した文字列の場合削除する
     *
     * @param string $src 検索文字列
     * @param string $target 指定文字列
     * @return void
     */
    function delEndsWith(string $src, string $target)
    {

        $result = $src;
        if (substr($src, -1) === $target) {
            $result = substr($src, 0, -1);
        }
        return $result;
    }
}
