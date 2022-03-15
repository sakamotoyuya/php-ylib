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
}
