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
    private array $postParameter = [];

    public function setPathParameter(array $parameter)
    {
        $this->pathParameter = $parameter;
    }


    public function getPathParameter($key)
    {
        return $this->pathParameter[$key];
    }

    public function setPostParameter(string $key, $val)
    {
        $this->postParameter[$key] = $val;
    }

    public function getPostParameter($key)
    {
        return $this->postParameter;
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
}
