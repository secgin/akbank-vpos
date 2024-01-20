<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface SaleResult
{
    public function getOrderId(): string;

    public function getTransIs(): string;

    public function isPaymentSuccess(): bool;
}