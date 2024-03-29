<?php

namespace YLibs;

use Exception;
use YLibs\Common\Csrf;
use YLibs\Common\Session;

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

    /**
     * パスパラメータ設定
     *
     * @param array $parameter
     * @return void
     */
    public function setPathParameter(array $parameter)
    {
        $this->pathParameter = $parameter;
    }

    /**
     * パスパラメータ取得
     *
     * @param string $key
     * @return mixed
     */
    public function getPathParameter(string $key)
    {
        return @$this->pathParameter[$key];
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
            throw new Exception("存在しないパスです", 404);
        }

        //viewへ値渡しする変数を作成する
        foreach ($this->variables as $ylibs_variable_name => $ylibs_variable_value) {
            ${$ylibs_variable_name} = $ylibs_variable_value;
        }
        /*
        $nameと$valueの変数名を使っていたが、$nameと$valueを
        変数名として使いたいときに値が上書きされてしまうので
        名前を使わない名前に変更  
        [$ylibs_variable_nameと$ylibs_variable_value]の変数名は使わないこと。
        */
        unset($ylibs_variable_name);
        unset($ylibs_variable_value);

        include($filepath);
    }

    /**
     * 指定したscriptを表示する
     *
     * @param string $filepath jsフォルダからのファイルパス
     * @return void
     */
    public function script(string $filepath)
    {
        $filepath = Script::getDir() . $filepath;
        if (!file_exists($filepath)) {
            throw new Exception("存在しないパスです", 404);
        }

        //scriptへ値渡しする変数を作成する
        foreach ($this->variables as $ylibs_variable_name => $ylibs_variable_value) {
            ${$ylibs_variable_name} = $ylibs_variable_value;
        }
        /*
        $nameと$valueの変数名を使っていたが、$nameと$valueを
        変数名として使いたいときに値が上書きされてしまうので
        名前を使わない名前に変更  
        [$ylibs_variable_nameと$ylibs_variable_value]の変数名は使わないこと。
        */
        unset($ylibs_variable_name);
        unset($ylibs_variable_value);

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
        //アクセスされる都度セッションを再生成する
        //以下が連続で呼び出されるとセッションが消えてしまうため
        //セッションハイジャック対策はログインしたときのみにする。
        // Session::regenerate();
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            // get
            Csrf::setToken();
            $this->get();
        } else {
            // POST
            Csrf::check();
            $this->post();
        }
    }

    /**
     * POST判定※CSRF対策含む
     *
     * @return bool
     */
    public function isPOST()
    {
        //アクセスされる都度セッションを再生成する
        //以下が連続で呼び出されるとセッションが消えてしまうため
        //セッションハイジャック対策はログインしたときのみにする。
        // Session::regenerate();
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            // get
            Csrf::setToken();
            return false;
        } else {
            // POST
            Csrf::check();
            return true;
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
        exit;
    }

    /**
     * ホストルートから相対指定パスの指定から
     * 絶対指定のURLを取得する
     *
     * @param string $filePath ルートからの相対パスを指定する
     * @return string 絶対パス
     */
    public function fullPath(string $filePath = ""): string
    {
        //指定文字の先頭が/で始まっていない場合は/を先頭に付与する
        if (!preg_match('{^/}', $filePath)) {
            $filePath = "/" . $filePath;
        }
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $filePath;
    }
}
