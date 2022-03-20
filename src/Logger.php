<?php

namespace YLibs;

use Exception;

class Logger
{
    public static function _print($method = "", $variable = "")
    {

        //ログファイルへの書き込み処理
        //  例外オブジェクトを生成。
        $e = new Exception;
        //  トレース配列を取得。
        $arys = $e->getTrace();

        $now = microtime(true);
        # 小数点以下から、上3桁をミリ秒として取得する
        $ms = (int)(($now - (int)$now) * 1000);
        $msStr = str_pad($ms, 3, 0, STR_PAD_LEFT);
        //配列の場合は配列を文字列に変換する。
        $variable = is_array($variable) ? implode(" , ", $variable) : $variable;
        $val = '[' . date("Y/m/d H:i:s") . $msStr . ']' . $arys[0]['file'] . '(' . $arys[0]['line'] . '):' . $method . '[' . $variable . ']';

        //ログファイルが存在しない場合
        if (!self::isExistLogFile()) {
            //ログファイルを作成する
            self::makefile();
        }

        // 容量チェック
        if (self::isOverFileSize(self::getNewLogfilePath())) {
            //ファイル数チェック
            if (self::isOverFilecount()) {
                // echo "ファイル数オーバー";
                //ファイル数がオーバーしていたら最古のログを削除する
                unlink(self::getOldLogFilePath());
            }
            //新しいファイルを作成する
            self::makefile();
        }
        //最新のファイルにログを書き込む
        error_log("$val\n", 3, self::getNewLogfilePath());
    }

    //ログファイルを日付を指定してファイルを生成する
    private static function makefile()
    {
        // 作成するファイル名の指定
        $dir = './logs/';
        mkdir($dir, 0777); //ディレクトリを作成する
        $now = date("Ymd_His");
        $file_name = $dir . $now . '_LOG.log';
        // echo $file_name;
        // $file_name = './logs/file.txt';
        // ファイルの存在確認
        if (!file_exists($file_name)) {
            // ファイル作成
            touch($file_name);
            // ファイルのパーミッションの変更
            chmod($file_name, 0666);
        } else {
            // すでにファイルが存在する為エラーとする
            // echo('Warning - ファイルが存在しています。 file name:['.$file_name.']');
            // exit();
        }
    }

    //logsフォルダ内のlogファイルを全て取得する
    private static function getLogfiles()
    {
        return glob('./logs/*.log');
    }

    //logsフォルダにlogファイルが存在するか
    private static function isExistLogFile()
    {
        if (0 < count(self::getLogfiles())) {
            return true;
        }
        return false;
    }

    //最新のファイルを取得する
    private static function getNewLogfilePath()
    {
        if (self::isExistLogFile()) {
            //ログファイルが存在する場合
            $new = count(self::getLogfiles()) - 1;
            return self::getLogfiles()["$new"];
        } else {
            return false;
        }
    }


    //最古のファイルを取得する
    private static function getOldLogFilePath()
    {
        if (self::isExistLogFile()) {
            //ログファイルが存在する場合
            return self::getLogfiles()['0'];
        } else {
            return false;
        }
    }

    //ファイル容量がオーバー(1MB未満)しているか
    private static function isOverFileSize($filepath)
    {
        //ファイル操作関連のapiはapiを仕様時にメソッドの戻り値がキャッシュした
        //戻り値を返却することがあるため、キャッシュをクリアすることで解決できる。
        clearstatcache();
        //ファイル書き込みを連続で行なった場合
        //一回の通信でのログ書き込み開始時に取得したファイルサイズが
        //全て同じ値で取得してしまう。
        //一回の通信で連続ログ書き込みを行なった場合は
        //ファイルサイズが最初に取得した値のものとなってしまう。
        //対策方法があるか調査が必要だが、
        //1回の通信で1MB以上のログを残す動作はなかなかしないので、
        //とりあえず現状で進める。
        //時間のあるときにちょうさすること。
        $size = filesize($filepath);
        // var_dump($size);
        $max = 1024 * 1024 * 1;
        if ($max < $size) {
            //オーバーしている時
            return true;
        }
        //オーバーしていない時
        return false;
    }

    //ファイル数がオーバー(5個以上)しているか
    private static function isOverFilecount()
    {
        $count = count(self::getLogfiles());
        $max = 5;
        if ($max <= $count) {
            //オーバーしている時
            return true;
        }
        //オーバーしていない時
        return false;
    }
}
