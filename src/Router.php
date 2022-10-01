<?php

namespace YLibs;

use Exception;
use YLibs\Logger;
use YLibs\Common\YString;

// use Controller;

/**
 * URLルーティング
 */
class Router
{
    private array $routes = [];
    private array $prefixMatchRoutes = [];
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
                // echo "<br>■\$request_url<br>";
                // var_dump($request_url);

                // echo "<br>■\$prefix<br>";
                // var_dump($prefix);

                //プレフィクスを消してリクエストパラメータのみにする
                $request_param = $this->ys->delStartsWith($request_url, $prefix);
                // echo "<br>■\$request_param-先頭プレフィクス削除<br>";
                // var_dump($request_param);
                $request_param = $this->ys->delEndsWith($request_param, "/");
                // echo "<br>■\$request_param-後方削除<br>";
                // var_dump($request_param);

                // var_dump($request_param);
                // var_dump(explode("/", $request_param));
                $request_param_list = explode("/", $request_param);
                // echo "<br>■\$request_param_list<br>";
                // var_dump($request_param_list);

                //前方一致リストの後方パラメータ部分を分割して
                //キー値を取得するurl部分をキー値にする
                for ($i = 0; $i < count($prefix_param_list); $i++) {
                    $key = $this->ys->delEndsWith($prefix_param_list[$i], "/");
                    $data = @$request_param_list[$i];
                    $pathparam[$key] = $data;
                }

                // echo "<br>■\$prefix_param_list<br>";
                // var_dump($prefix_param_list);
                // echo "<br>■\$request_param_list<br>";
                // var_dump($request_param_list);
                // echo "<br>■\$pathparam<br>";
                // var_dump($pathparam);

                foreach ($this->prefixMatchRoutes[$prefix_param] as $class => $method) {
                    $class = $this->namespace . $class;
                    $controller = new $class;
                    // $controller = new ($this->namespace . $class);
                    $controller->setPathParameter($pathparam);
                    $controller->$method();
                }
                return;
            }
        }

        //完全一致判定
        if (!isset($this->routes[$request_url])) {
            Logger::_print(__METHOD__, "\$request_url:" . $request_url);
            // Logger::_print(__METHOD__, "\$request_url:" . print_r($request_urls,true));//print_rで配列展開
            // var_dump($request_url);
            // exit;
            throw new Exception("存在しないURLです");
        }

        foreach ($this->routes[$request_url] as $class => $method) {
            $class = $this->namespace . $class;
            $controller = new $class;
            // $controller = new ($this->namespace . $class);
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
    public function setMapping(string $url, string $class, ?string $method): self
    {
        $this->routes[$url] = [$class => $method];
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
    public function setPrefixMapping(string $url, string $class, ?string $method): self
    {
        $this->prefixMatchRoutes[$url] = [$class => $method];
        return $this;
    }
}
