<?php

namespace YLibs\Common;

class Utility
{
    public function __construct()
    {
    }
    // 指定されたURLへリダイレクトする
    static public function redirect($url)
    {
        header('Location:' .  $url);
        exit;
    }

    /**
     * ランダムの暗号化キーを取得する
     *
     * @return string
     */
    static public function getRandomKey(): string
    {
        return sha1(uniqid(mt_rand(), true));
    }

    /**
     * 本日から指定年数後のフォーマット後の有効期限日時を取得する
     *
     * @param int $year 年
     * @return string
     */
    static public function getExpireDateTimeFormat(int $year = 1): string
    {
        return date('Y-m-d H:i:s', time() + $year * 3600 * 24 * 365);
    }

    /**
     * 本日から指定年数後の有効期限日時を取得する
     *
     * @param int $year 年
     * @return int
     */
    static public function getExpireDateTime(int $year = 1): int
    {
        return time() + $year * 3600 * 24 * 365;
    }
}
