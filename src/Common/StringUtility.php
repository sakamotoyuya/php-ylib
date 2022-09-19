<?php

namespace YLibs\Common;

class StringUtility
{
    public function __construct()
    {
    }

    //------------------------------------------------------------------------------
    /**
     * 一度だけ論理値を判定して文字列を返却する
     *
     * @param bool $first 論理値
     * @param string $trueValue 返却文字列(true)
     * @param string $falseValue 返却文字列(false)
     * @return string 文字列
     */
    static public function chooseOnce(bool &$first, string $trueValue, string $falseValue): string
    {
        if ($first) {
            $first = false;
            return $trueValue;
        }
        return $falseValue;
    }

    /**
     * スネークケースから先頭大文字ケースに変換して返却する
     *
     * @param string $target
     * @return string
     */
    static function snakeToCamel(string $target): string
    {
        $arr = explode("_", $target);
        $result = "";
        foreach ($arr as $val) {
            $result = $result . ucfirst($val);
        }
        return $result;
    }
}
