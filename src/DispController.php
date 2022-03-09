<?php
//https://tech.012grp.co.jp/entry/2021/02/01/110657
namespace YLibs;

use YLibs\DispInterface;

class DispController
{
    //直接の呼出ではなくinterfaceのみを使うことで結合度を下げることができる
    private $service;

    public function __construct(DispInterface $dispInterface)
    {
        $this->service = $dispInterface;
    }

    public function start(): String
    {
        return $this->service->start();
    }

    public function stop(): String
    {
        return $this->service->stop();
    }
}
