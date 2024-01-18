<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface ThreeDSecureControl
{
    public function getClientId(): string;


    public function getAmount(): float;

    public function getOrderId(): ?string;

    public function getRnd(): string;

    public function getHash(): string;

    public function getDescription(): ?string;

    public function getXid(): ?string;

    public function getLang(): ?string;

    public function getEmail(): ?string;

    public function getUserId(): ?string;
}