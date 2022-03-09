<?php

namespace YLibs;

use YLibs\DispInterface;

class Disp implements DispInterface
{
    public function hello()
    {
        echo "こんにちわ";
    }

    public function start(): String
    {
        return "start";
    }

    public function stop(): String
    {
        return "stop";
    }
}
