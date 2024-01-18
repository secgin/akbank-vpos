<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface Payment
{
    public function getMd(): string;

    public function getEci(): string;

    public function getXid(): string;

    public function getCavv(): string;
}