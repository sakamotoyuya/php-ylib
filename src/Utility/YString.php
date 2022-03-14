<?php

namespace YLibs\Utility;

use Exception;

/**
 * 文字列操作クラス
 */
class YString
{

    /**
     * 文字列の末尾が指定文字列の場合末尾文字を削除したものを返却する
     * 指定文字列の場合検索文字列をそのまま返却する
     *
     * @param string $src 検索文字列
     * @param string $target 指定文字列
     * @return string
     * @throws Exception $targetが1文字以外のき
     */
    function delEndsWith(string $src, string $target): string
    {
        if (strlen($target) !== 1) {
            throw new Exception("targetが1文字ではありません。");
        }

        $result = $src;
        if (substr($src, -1) === $target) {
            $result = substr($src, 0, -1);
        }
        return $result;
    }

    /**
     * 文字列の先頭が指定文字列の場合、先頭の指定文字列を削除したものを返却する
     * 指定文字列が存在しない場合検索文字列をそのまま返却する
     *
     * @param string $src 検索文字列
     * @param string $target 指定文字列
     * @return string
     * @throws Exception $targetが1文字以外のき
     */
    function delStartsWith(string $src, string $target): string
    {
        $length = strlen($target);
        if ($length === null) {
            throw new Exception("targetがnullです。");
        }

        $result = $src;
        if (substr($src, 0, $length) === $target) {
            $result = substr($src, $length);
        }

        return $result;
    }
}
