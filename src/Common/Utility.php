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
}
