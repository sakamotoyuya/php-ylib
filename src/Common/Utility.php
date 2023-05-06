<?php

namespace YLibs\Common;

class Utility
{
    public function __construct()
    {
    }
    // 指定されたURLへリダイレクトする
    static public function redirect($url)
    {
        header('Location:' .  $url);
        exit;
    }

    /**
     * ランダムの暗号化キーを取得する
     *
     * @return string
     */
    static public function getRandomKey(): string
    {
        return sha1(uniqid(mt_rand(), true));
    }

    /**
     * 本日から指定年数後のフォーマット後の有効期限日時を取得する
     *
     * @param int $year 年
     * @return string
     */
    static public function getExpireDateTimeFormat(int $datetime = 0): string
    {
        if ($datetime == 0) {
            $datetime = time();
        }
        return date('Y-m-d H:i:s', $datetime);
    }

    /**
     * 本日から指定年数後の有効期限日時を取得する
     *
     * @param int $year 年
     * @return int
     */
    static public function getExpireDateTime(int $year = 0): int
    {
        if ($year == 0) {
            return time();
        }
        return time() + $year * 3600 * 24 * 365;
    }

    /**
     * 画面描画時にscriptとして認識させない文字に変換する
     *
     * @param [type] $org_str
     * @return string
     */
    static public function h($org_str): string
    {
        if (is_null($org_str)) {
            $org_str = "";
        }
        return htmlspecialchars($org_str, ENT_QUOTES, "UTF-8");
    }

    /**
     * ホストルートから相対指定パスの指定から
     * 絶対指定のURLを取得する
     *
     * @param string $filePath ルートからの相対パスを指定する
     * @return void
     */
    static public function fullPath(string $filePath = "")
    {
        return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . "/" . $filePath;
    }

    /**
     * 戻るリンクを取得する
     * ※リファラーがないときはデフォルトリンクを取得する
     *
     * @param string $defaultLink
     * @return void
     */
    static public function getBackLink(string $defaultLink = "/")
    {
        return is_null(@$_SERVER['HTTP_REFERER']) ? $defaultLink : $_SERVER['HTTP_REFERER'];
    }
}
