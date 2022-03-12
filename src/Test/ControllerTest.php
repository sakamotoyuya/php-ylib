<?php

namespace YLibs\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use YLibs\Controller;

final class ControllerTest extends TestCase
{
    private $target;
    /**
     * 本メソッドは各テストメソッドが実行される前に毎回実行される
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->target =  new class('target') extends Controller
        {
        };
    }

    /**
     * setメソッドのテスト
     *
     * @return void
     */
    public function testset()
    {

        $期待値1 = 1;
        $this->target->set("num", $期待値1);
        $this->assertSame($this->target->getValiables()["num"], $期待値1);

        $期待値2 = "文字列";
        $this->target->set("string", $期待値2);
        $this->assertSame($this->target->getValiables()["string"], $期待値2);

        $期待値3 = 1;
        $mock = new class("User")
        {
            public $num = 1;
        };

        $this->target->set("class", $mock);
        $this->assertSame($this->target->getValiables()["class"]->num, $期待値3);

        $期待値4 = [1, 2, 3];
        $this->target->set("array", $期待値4);
        $this->assertSame($this->target->getValiables()["array"], $期待値4);
    }

    /**
     * viewメソッド成功時のテスト
     */
    public function testview_成功()
    {
        try {
            $this->target->view(__DIR__ . "/ControllerDummy.php");
        } catch (Exception $e) {
            $this->fail('問題ないデータなのに拒絶されている');
        } finally {
            $this->assertFalse(isset($e), '例外が発生している');
        }
    }

    /**
     * viewメソッド失敗時の例外発生テスト
     */
    public function testview_失敗_例外発生()
    {
        try {
            $this->target->view(__DIR__ . "/こんなファイル存在しない.php");
        } catch (Exception $e) {
            $this->assertSame($e->getMessage(), "存在しないパスです");
        } finally {
            $this->assertTrue(isset($e), '例外が発生している');
        }
    }
}

// } catch (\InvalidArgumentException $e) {
//     $this->fail('問題ないデータなのに拒絶されている');
// } finally {
//     $this->assertFalse(isset($e), '例外が発生している');
// }
// }