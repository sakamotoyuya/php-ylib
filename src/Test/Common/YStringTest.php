<?php

namespace YLibs\Test\Common;

use Exception;
use PHPUnit\Framework\TestCase;
use YLibs\Common\YString;

class YStringTest extends TestCase
{
    public function testDelEndsWidth_成功()
    {
        $期待値 = "https://abc.123/123";
        $条件「検索元」  = "https://abc.123/123/";
        $条件「検索値」 = "/";
        $ystr = new YString();
        $実際の値 = $ystr->delEndsWith($条件「検索元」, $条件「検索値」);
        $this->assertSame($実際の値, $期待値);
    }

    public function testDelEndsWidth_成功_エスケープ文字の検索()
    {
        $期待値 = "https://abc.123/123";
        $条件「検索元」  = "https://abc.123/123\\";
        $条件「検索値」 = "\\";
        $ystr = new YString();
        $実際の値 = $ystr->delEndsWith($条件「検索元」, $条件「検索値」);
        $this->assertSame($実際の値, $期待値);
    }

    public function testDelEndsWidth_成功_検索文字がヒットしない場合()
    {
        $期待値 = "";
        $条件「検索元」  = "";
        $条件「検索値」 = "/";
        $ystr = new YString();
        $実際の値 = $ystr->delEndsWith($条件「検索元」, $条件「検索値」);
        $this->assertSame($実際の値, $期待値);
    }

    public function testDelEndsWidth_失敗_検索文字が0文字のテスト()
    {

        try {
            $期待値 = "targetが1文字ではありません。";
            $条件「検索元」 = "https://abc.123/123/";
            $条件「検索値」 = "";
            $ystr = new YString();
            $ystr->delEndsWith($条件「検索元」, $条件「検索値」);
        } catch (Exception $e) {
            $実際の値 = $e->getMessage();
            $this->assertSame($実際の値, $期待値);
        } finally {
            $this->assertTrue(isset($e), '例外が発生している');
        }
    }

    public function testDelEndsWidth_失敗_検索文字が2文字のテスト()
    {

        try {
            $期待値 = "targetが1文字ではありません。";
            $条件「検索元」 = "https://abc.123/123/";
            $条件「検索値」 = "32";
            $ystr = new YString();
            $ystr->delEndsWith($条件「検索元」, $条件「検索値」);
        } catch (Exception $e) {
            $実際の値 = $e->getMessage();
            $this->assertSame($実際の値, $期待値);
        } finally {
            $this->assertTrue(isset($e), '例外が発生している');
        }
    }
}
