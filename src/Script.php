<?php

namespace YLibs;

class Script
{
    static private $dir = __DIR__;

    static public function getDir()
    {
        return (self::$dir);
    }

    static public function setDir($dir)
    {
        self::$dir = $dir;
    }
}
