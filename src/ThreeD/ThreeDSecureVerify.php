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