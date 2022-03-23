<?php

namespace YLibs\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use YLibs\Logger;

final class LoggerTest extends TestCase implements protocol
{
    public function testA()
    {
        Logger::_print();
        $this->assertSame("こんちわ", "こんちわ");
        // $obj = new Human();
        // $this->assertSame("こんにちわ",$obj->helloString());
    }

    /**
     * @test
     */
    function ログテスト()
    {
        Logger::_print("ロガーテスト");
        // $this->a();
    }

    function a()
    {
        $e = new Exception();
        //  トレース配列を取得。
        $arys = $e->getTrace();
        var_dump($arys);
    }
}

interface protocol
{
    function a();
}
