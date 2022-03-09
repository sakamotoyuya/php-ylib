<?php

namespace YLibs\Test;

use PHPUnit\Framework\TestCase;
use YLibs\Disp;
use YLibs\DispController;

final class DispControllerTest extends TestCase
{
    // private $target;
    //setupメソッドで各テストメソッドが実行される前に毎回実行される
    protected function setUp(): void
    {
        $this->target = new DispController(new Disp);
    }

    public function testA()
    {
        // $target = new DispController(new Disp);
        $期待値 = "start";
        $実際の値 = $this->target->start();
        $this->assertSame($期待値, $実際の値);
    }

    public function testB()
    {
        // $target = new DispController(new Disp);

        $期待値 = "start";
        $実際の値 = $this->target->start();
        $this->assertSame($期待値, $実際の値);
    }
}
