<?php

namespace YLibs\Test;

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

    function a()
    {
        echo "a";
    }
}

interface protocol
{
    function a();
}
