<?php

namespace YG\AkbankVPos\ThreeD;

use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureControl as ThreeDSecureControlInterface;

class ThreeDSecureControl implements ThreeDSecureControlInterface
{
    private string $clientId;


    private float $amount;

    private ?string $orderId = null;

    private string $rnd;

    private string $hash;

    private ?string $description = null;

    private ?string $xid = null;

    private ?string $lang = null;

    private ?string $email = null;

    private ?string $userId = null;

    private function __construct(float  $amount, string $rnd, string $hash,
                                 string $orderId = null)
    {
    }

    public static function create(float  $amount, string $rnd, string $hash,
                                  string $orderId = null): ThreeDSecureControlInterface
    {
        return new ThreeDSecureControl($amount, $rnd, $hash, $orderId);
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setXid(?string $xid): self
    {
        $this->xid = $xid;
        return $this;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;
        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setUserId(?string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getRnd(): string
    {
        return $this->rnd;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getXid(): ?string
    {
        return $this->xid;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }
}