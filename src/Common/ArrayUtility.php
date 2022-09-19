<?php

namespace YLibs\Common;

class ArrayUtility
{
    public function __construct()
    {
    }

    /**
     * 配列に要素が存在するか
     *
     * @param ?array $list
     * @return bool 存在する：true｜存在しない：false
     */
    static public function isExist(?array $list): bool
    {
        $result = true;
        if (is_null($list)) {
            return false;
        }

        if (count($list) == 0) {
            $result = false;
        }

        return $result;
    }

    /**
     * 配列にキーを指定した際の値を返却する。存在しない場合はnullを返却する。
     *
     * @param string $key
     * @param array $arr
     * @return mixed
     */
    static public function getArrayValue(string $key, array $arr): mixed
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        }
        return null;
    }
}
