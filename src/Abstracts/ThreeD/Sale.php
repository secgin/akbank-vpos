<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface Sale
{
    public function getAmount(): float;

    public function getInstallment(): ?int;

    public function getCurrency(): string;

    public function getOrderId(): string;

    public function getXid(): string;

    public function getEci(): string;

    public function getCavv(): string;

    public function getMd(): string;

    public function getIpAddress(): string;
}