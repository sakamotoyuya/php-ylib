<?php

namespace YLibs;

use Exception;

/**
 * Controller
 */
abstract class Controller
{
    /**
     * 変数格納テーブル
     * 本テーブルに[変数:値]の組み合わせでデータを保管する
     *
     * @var array
     */
    private array $variables = [];
    private array $pathParameter = [];

    abstract protected function get();

    abstract protected function post();

    public function setPathParameter(array $parameter)
    {
        $this->pathParameter = $parameter;
    }

    public function getPathParameter($key)
    {
        return $this->pathParameter[$key];
    }

    /**
     * 指定したviewを表示する
     *
     * @param string $filepath viewフォルダからのファイルパス
     * @return void
     */
    public function view(string $filepath)
    {
        $filepath = View::getDir() . $filepath;
        if (!file_exists($filepath)) {
            throw new Exception("存在しないパスです");
        }

        //viewへ値渡しする変数を作成する
        foreach ($this->variables as $name => $value) {
            ${$name} = $value;
        }

        include($filepath);
    }

    /**
     * viewへ値しするための変数の設定を行う。
     *
     * @param string $name 変数名
     * @param mixed $value 値
     * @return void
     */
    public function set(String $name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * 変数格納テーブルを取得する
     *
     * @return void
     */
    public function getValiables()
    {
        return $this->variables;
    }

    /**
     * indexを指定された場合は本メソッドを呼び出す
     *
     * @return void
     */
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            // get
            $this->get();
        } else {
            // POST
            $this->post();
        }
    }

    /**
     * リダイレクト
     *
     * @param string $url リダイレクト先のURL
     * @return void
     */
    protected function redirect(string $url)
    {
        header("Location:" . $url);
    }
}
