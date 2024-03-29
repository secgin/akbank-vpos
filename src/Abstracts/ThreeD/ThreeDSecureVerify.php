<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface ThreeDSecureVerify
{
    public function isHashValid(): bool;

    public function isAuthenticationSuccessful();

    public function getClientId(): string;

    public function getOrderId(): string;

    public function getAmount(): float;

    public function getCurrency(): string;

    public function getXid(): string;

    public function getEci(): string;

    public function getCavv(): string;

    public function getMd(): string;

}