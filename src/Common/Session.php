<?php

namespace YLibs\Common;

class Session
{
    public function __construct()
    {
    }

    static public function start()
    {
        session_start();
    }

    static public function destroy()
    {
        session_destroy();
    }

    static public function set(string $key, string $val)
    {
        $_SESSION[$key] = $val;
    }

    static public function get(string $key)
    {
        return $_SESSION[$key];
    }
}
