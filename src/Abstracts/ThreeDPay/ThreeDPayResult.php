<?php

namespace YG\AkbankVPos\Abstracts\ThreeDPay;

interface ThreeDPayResult
{
    public function isHashValid(): bool;

    public function isAuthenticationSuccessful(): bool;

    public function isSuccessPayment(): bool;

    public function getAuthCode(): string;

    public function getHostRefNun(): string;

    public function getProcReturnCode(): string;

    public function getTransId(): string;

    public function getErrMsg(): string;
}