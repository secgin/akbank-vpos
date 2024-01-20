<?php

namespace YG\AkbankVPos\ThreeD;

class Sale implements \YG\AkbankVPos\Abstracts\ThreeD\Sale
{
    private float $amount;

    private ?int $installment = null;

    private string
        $currency,
        $orderId,
        $xid,
        $eci,
        $cavv,
        $md,
        $ipAddress;

    public function __construct(float  $amount, string $currency, string $orderId, string $xid, string $eci,
                                string $cavv, string $md, string $ipAddress)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->orderId = $orderId;
        $this->xid = $xid;
        $this->eci = $eci;
        $this->cavv = $cavv;
        $this->md = $md;
        $this->ipAddress = $ipAddress;
    }

    public static function create(float  $amount, string $currency, string $orderId, string $xid, string $eci,
                                  string $cavv, string $md, string $ipAddress): Sale
    {
        return new Sale($amount, $currency, $orderId, $xid, $eci, $cavv, $md, $ipAddress);
    }

    public function setInstallment(int $installment): Sale
    {
        $this->installment = $installment;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getInstallment(): ?int
    {
        return $this->installment;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getXid(): string
    {
        return $this->xid;
    }

    public function getEci(): string
    {
        return $this->eci;
    }

    public function getCavv(): string
    {
        return $this->cavv;
    }

    public function getMd(): string
    {
        return $this->md;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}