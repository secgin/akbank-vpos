<?php

namespace YG\AkbankVPos\ThreeD;

class ThreeDSecureVerify implements \YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureVerify
{
    private array $data;

    private string $storeKey;

    public function __construct(array $data, string $storeKey)
    {
        $this->data = $data;
        $this->storeKey = $storeKey;
    }

    public static function create(array $data, string $storeKey): ThreeDSecureVerify
    {
        return new ThreeDSecureVerify($data, $storeKey);
    }

    public function isHashValid(): bool
    {
        $hashParams = $_POST["HASHPARAMS"] ?? null;
        $hashParamsVal = $_POST["HASHPARAMSVAL"] ?? null;
        $hash = $_POST["HASH"] ?? null;

        if ($hashParams == '' or $hashParamsVal == '' or $hash == '')
            return false;

        $hashVal = join('',
            array_map(fn($item) => $this->data[$item] ?? '', explode(':', $hashParams)));

        if ($hashVal != $hashParamsVal)
            return false;

        $newHash = base64_encode(pack('H*', sha1($hashVal.$this->storeKey)));

        return $newHash == $hash;
    }

    public function isAuthenticationSuccessful(): bool
    {
        if (!$this->isHashValid())
            return false;

        $mdStatus = $this->data['mdStatus'] ?? '';

        return $mdStatus == '1' or $mdStatus == '2' or $mdStatus == '3' or $mdStatus == '4';
    }

    public function getClientId(): string
    {
        return $this->data['clientid'] ?? '';
    }

    public function getOrderId(): string
    {
        return $this->data['oid'] ?? '';
    }

    public function getAmount(): float
    {
        return $this->data['amount'] ?? 0;
    }

    public function getCurrency(): string
    {
        return $this->data['currency'] ?? '';
    }

    public function getXid(): string
    {
        return $this->data['xid'] ?? '';
    }

    public function getEci(): string
    {
        return $this->data['eci'] ?? '';
    }

    public function getCavv(): string
    {
        return $this->data['cavv'] ?? '';
    }

    public function getMd(): string
    {
        return $this->data['md'] ?? '';
    }
}