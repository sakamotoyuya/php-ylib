<?php

namespace YLibs\Common;

class Csrf
{
    static private $key;

    /**
     * トークンが正常化チェックする
     * 
     * フォームが存在する画面などの、POST受信制御処理を行う箇所でチェックを行うこと。
     *
     * @return void
     */
    static public function check()
    {
        if (is_null(Csrf::getToken()) || (Csrf::getToken() != $_POST[Csrf::getKey()])) {

            echo "<html>
            <head>
                <meta charset=\"utf-8\">
                <style>
                *{
                    margin:0;
                    padding:0;
                }
                h1{
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    color:red;
                    height:100vh;
                    width:100%;
                }
                </style>
                </head>
            <body>
            <h1>不正なアクセスです。</h1>
            </body>
            </html>";
            exit;
        }
    }

    /**
     * Get the value of key
     */
    static public function getKey()
    {
        return self::$key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */
    static public function setKey($key)
    {
        self::$key = $key;
    }

    /**
     * Get the value of token
     */
    static public function getToken()
    {
        return @Session::get(Csrf::getKey());
    }

    /**
     * Set the value of token
     *
     * @return  void
     */
    static public function setToken()
    {
        Session::set(self::getKey(), Utility::getRandomKey());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    static public function tag()
    {
        $key = Csrf::getKey();
        $csrftoken = Utility::h(Csrf::getToken());
        echo '<input type="hidden" name="' . $key . '" value="' . $csrftoken . '" />';
    }
}
