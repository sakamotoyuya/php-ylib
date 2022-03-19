<?php

namespace YLibs\Common;

class Cookie
{
    public function __construct()
    {
    }

    static public function set(string $name, $value = "", $expires_or_options = 0, $path = "", $domain = "", $secure = false, $httponly = false)
    {
        setcookie($name, $value, $expires_or_options, $path, $domain, $secure, $httponly);
    }
    static public function get(string $key)
    {
        return $_COOKIE[$key];
    }
}
