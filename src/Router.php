<?php

namespace YLibs;

use Exception;
use YLibs\Logger;
use YLibs\Utility\YString;

// use Controller;

/**
 * URLルーティング
 */
class Router
{
    private array $routes;
    private string $namespace;
    private YString $ys;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
        $this->ys = new YString();
    }

    /**
     * ルート振り分け
     *
     * @return void
     * @throws Exception 
     */
    public function run()
    {
        $url = $_SERVER["REQUEST_URI"];
        //パラメータとurlの分解の処理

        // 末尾のスラッシュを強制削除
        $url = $this->ys->delEndsWith($url, '/');
        if ($url !== '') {
            //スラッシュで分割して配列にする
            $urls = explode("/", $url);
            //先頭が余分なので削除。(必ずarray[0]が空文字となるので1つ取り出して排除する)
            array_shift($urls);
            //末尾のキー値を取り出す
            $lastkey = array_key_last($urls);
            //末尾の要素を?で分割して配列にして先頭だけ取り出す(/abc?a=1&b=2)→(abcを取り出して元の配列に戻す)
            $urls[$lastkey] = explode("?", $urls[$lastkey])[0];
            $url = "/" . implode("/", $urls);
        }
        $url = $this->ys->delEndsWith($url, "/") . "/";

        if (!isset($this->routes[$url])) {
            Logger::_print($urls, __METHOD__);
            var_dump($url);
            echo "存在しない画面です。";
            exit;
            throw new Exception("存在しないURLです");
        }

        foreach ($this->routes[$url] as $class => $method) {
            $controller = new ($this->namespace . $class);
            $controller->$method();
        }
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $class
     * @param string|null $method
     * @return void
     */
    public function setMapping(string $url, string $class, ?string $method)
    {
        $this->routes[$url] = [$class => $method];
    }
}
