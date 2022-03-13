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
    private $variables = [];
    private array $pathParameter = [];

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
     * @param string $url viewのurl
     * @return void
     */
    public function view(string $url)
    {
        $url = View::getDir() . $url;
        if (!file_exists($url)) {
            throw new Exception("存在しないパスです");
        }

        //viewへ値渡しする変数を作成する
        foreach ($this->variables as $name => $value) {
            ${$name} = $value;
        }

        include($url);
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
}
