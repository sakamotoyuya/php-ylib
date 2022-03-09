<?php

namespace YLibs\Test;

use PHPUnit\Framework\TestCase;
use YLibs\Disp;
use YLibs\DispController;

final class DispControllerTest extends TestCase
{
    // private $準備;
    //setupメソッドで各テストメソッドが実行される前に毎回実行される
    protected function setUp(): void
    {
        $this->準備 = new DispController(new Disp);
    }

    public function testA()
    {
        // $準備 = new DispController(new Disp);
        $期待値 = "start";
        $処理結果 = $this->準備->start();
        $this->assertSame($期待値, $処理結果);
    }

    public function testB()
    {
        // $準備 = new DispController(new Disp);

        $期待値 = "start";
        $処理結果 = $this->準備->start();
        $this->assertSame($期待値, $処理結果);
    }
}
