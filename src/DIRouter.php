<?php

namespace YLibs;

use DI\ContainerBuilder;
use Exception;
use YLibs\Common\YString;


// use Controller;

/**
 * URLルーティング
 */
class DIRouter
{
    private array $routes = [];
    private array $prefixMatchRoutes = [];
    private string $config;
    private YString $ys;

    public function __construct($config)
    {
        $this->config = $config;
        $this->ys = new YString();
    }

    /**
     * ルート振り分け
     *
     * @return void
     * @throws Exception 
     */
    public function run($role)
    {
        $request_url = $_SERVER["REQUEST_URI"];
        //パラメータとurlの分解の処理

        // 末尾のスラッシュを強制削除
        $request_url = $this->ys->delEndsWith($request_url, '/');
        if ($request_url !== '') {
            //スラッシュで分割して配列にする
            $request_urls = explode("/", $request_url);
            //先頭が余分なので削除。(必ずarray[0]が空文字となるので1つ取り出して排除する)
            array_shift($request_urls);
            //末尾のキー値を取り出す
            $lastkey = array_key_last($request_urls);
            //末尾の要素を?で分割して配列にして先頭だけ取り出す(/abc?a=1&b=2)→(abcを取り出して元の配列に戻す)
            $request_urls[$lastkey] = explode("?", $request_urls[$lastkey])[0];
            $request_url = "/" . implode("/", $request_urls);
        }
        $request_url = $this->ys->delEndsWith($request_url, "/") . "/";

        //前方一致判定（ここは変数込みのもの）
        foreach (array_keys($this->prefixMatchRoutes) as $prefix_param) {
            //前方部分を抜き出し
            //:から後ろで配列分割
            //0番目はurlの値なので1番目以降からは:付きとする
            $prefix_param_list = explode(":", $prefix_param);
            $prefix = $prefix_param_list[0];
            array_shift($prefix_param_list);
            // var_dump($prefix);
            // 先頭のURL部分のみを取る
            // パス区切りの数が同じ && 前方一致判定
            if (
                (count(explode("/", $request_url)) == count(explode("/", $prefix_param)))
                && preg_match("{^" . $prefix . "}", $request_url)
            ) {

                //プレフィクスを消してリクエストパラメータのみにする
                $request_param = $this->ys->delStartsWith($request_url, $prefix);
                $request_param = $this->ys->delEndsWith($request_param, "/");

                $request_param_list = explode("/", $request_param);

                //前方一致リストの後方パラメータ部分を分割して
                //キー値を取得するurl部分をキー値にする
                for ($i = 0; $i < count($prefix_param_list); $i++) {
                    $key = $this->ys->delEndsWith($prefix_param_list[$i], "/");
                    $data = @$request_param_list[$i];
                    $pathparam[$key] = $data;
                }

                foreach ($this->prefixMatchRoutes[$prefix_param]["class"] as $class => $method) {
                    $controller = $this->getController($class);
                    if (!$this->isAuthRole($this->prefixMatchRoutes[$prefix_param]["role"], $role)) {
                        throw new Exception("URLが見つかりません。", 404);
                    }
                    $controller->setPathParameter($pathparam);
                    $controller->$method();
                }
                return;
            }
        }

        //完全一致判定
        if (!isset($this->routes[$request_url])) {
            // Logger::_print(__METHOD__, "\$request_url:" . $request_url);
            throw new Exception("存在しないURLです");
        }

        foreach ($this->routes[$request_url]["class"] as $class => $method) {
            $controller = $this->getController($class);
            if (!$this->isAuthRole($this->routes[$request_url]["role"], $role)) {
                throw new Exception("URLが見つかりません。", 404);
            }
            $controller->$method();
        }
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $class
     * @param string|null $method
     * @return self
     */
    public function setMapping(string $url, string $class, ?string $method, int $role = 0): self
    {
        $this->routes[$url] = [
            "class" => [$class => $method],
            "role" => $role
        ];
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $class
     * @param string|null $method
     * @return self
     */
    public function setPrefixMapping(string $url, string $class, ?string $method, int $role = 0): self
    {
        $this->prefixMatchRoutes[$url] = [
            "class" => [$class => $method],
            "role" => $role
        ];
        return $this;
    }

    /**
     * 権限チェック
     *
     * @param int $role
     * @param int $runRole
     * @return bool
     */
    private function isAuthRole(int $role, int $runRole): bool
    {
        if ($role == 0) {
            return true;
        }

        if ($role != $runRole) {
            return false;
        }

        return true;
    }

    public function getController($class)
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAttributes(true);
        $containerBuilder->addDefinitions($this->config);
        $container = $containerBuilder->build();
        $controller = $container->get($class);
        return $controller;
    }
}
