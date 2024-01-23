<?php

namespace YG\AkbankVPos\ThreeDPay;

final class ThreeDPayResult implements \YG\AkbankVPos\Abstracts\ThreeDPay\ThreeDPayResult
{
    private array $data;

    private string $storeKey;

    public function __construct(array $data, string $storeKey)
    {
        $this->data = $data;
        $this->storeKey = $storeKey;
    }

    public static function create(array $data, string $storeKey): ThreeDPayResult
    {
        return new ThreeDPayResult($data, $storeKey);
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

        $newHash = base64_encode(pack('H*', sha1($hashVal . $this->storeKey)));

        return $newHash == $hash;
    }

    public function isAuthenticationSuccessful(): bool
    {
        if (!$this->isHashValid())
            return false;

        $mdStatus = $this->data['mdStatus'] ?? '';

        return $mdStatus == '1' or $mdStatus == '2' or $mdStatus == '3' or $mdStatus == '4';
    }

    public function isSuccessPayment(): bool
    {
        return $this->isAuthenticationSuccessful() and ($this->data['Response'] ?? '') == 'Approved';
    }

    public function getAuthCode(): string
    {
        return $this->data['AuthCode'] ?? '';
    }

    public function getHostRefNun(): string
    {
        return $this->data['HostRefNum'] ?? '';
    }

    public function getProcReturnCode(): string
    {
        return $this->data['ProcReturnCode'] ?? '';
    }

    public function getTransId(): string
    {
        return $this->data['TransId'] ?? '';
    }

    public function getOrderId(): string
    {
        return $this->data['oid'] ?? '';
    }

    public function getErrMsg(): string
    {
        return $this->data['ErrMsg'] ?? '';
    }
}