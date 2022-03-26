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
        $_SESSION = array();
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
        //アクセスされる都度セッションを再生成する
        //以下が連続で呼び出されるとセッションが消えてしまうため
        //セッションハイジャック対策はログインしたときのみにする。
        // self::regenerate();
        $_SESSION[$key] = $val;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return mixed
     */
    static public function get(string $key): mixed
    {
        return @$_SESSION[$key];
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static public function regenerate()
    {
        session_regenerate_id(true);
    }
}
