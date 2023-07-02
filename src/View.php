<?php

namespace YLibs;

class View
{
    static private $dir = __DIR__;
    static private $title = "";

    static public function getDir()
    {
        return (self::$dir);
    }

    static public function setDir($dir)
    {
        self::$dir = $dir;
    }

    static public function setTitle($title)
    {
        self::$title = $title;
    }

    static public function getTitle()
    {
        return self::$title;
    }
}
