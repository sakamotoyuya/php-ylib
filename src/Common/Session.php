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

    /**
     * Undocumented function
     *
     * @param string $key
     * @param mixed $val
     * @return void
     */
    static public function set(string $key, mixed $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return void
     */
    static public function get(string $key)
    {
        return $_SESSION[$key];
    }
}
