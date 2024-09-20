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
        $postParams = array();
        foreach ($_POST as $key => $value)
            $postParams[] = $key;

        natcasesort($postParams);

        $hashVal = "";
        foreach ($postParams as $param){
            $paramValue = $_POST[$param];
            $escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));

            $lowerParam = strtolower($param);
            if($lowerParam != "hash" && $lowerParam != "encoding" )
                $hashVal = $hashVal . $escapedParamValue . "|";
        }

        $escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\",  $this->storeKey));
        $hashVal = $hashVal . $escapedStoreKey;

        $calculatedHashValue = hash('sha512', $hashVal);
        $actualHash = base64_encode (pack('H*',$calculatedHashValue));

        $retrievedHash = $_POST["HASH"];
        return $retrievedHash == $actualHash;
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

    public function getAmount(): ?float
    {
        return $this->data['amount'] ?? null;
    }

    public function getErrMsg(): string
    {
        return $this->data['ErrMsg'] ?? '';
    }
}