<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface SaleResult
{
    public function getOrderId(): string;

    public function getTransId(): string;

    public function isPaymentSuccess(): bool;
}