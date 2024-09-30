<?php

namespace YG\AkbankVPos\ThreeDPay;

use YG\AkbankVPos\Abstracts\ThreeDPay\ThreeDPaySecureParameter as ThreeDPaySecureParameterInterface;

class ThreeDPaySecureParameter implements ThreeDPaySecureParameterInterface
{
    private string
        $clientId,
        $storeKey,
        $okUrl,
        $failUrl,
        $rnd,
        $storeType = '3d_pay',
        $authType = 'Auth',
        $hasAlgorithm = 'ver3';

    private string $cardNumber;
    private string $expiryDateYear;
    private string $expiryDateMonth;
    private string $cvv;

    private string $cardType;

    private float $amount;

    private ?string
        $oid = null,
        $description = null,
        $lang = 'tr',
        $currency = '949',
        $email = null,
        $userId = null;

    private ?int $installment = null;

    private function __construct(string $clientId, string $storeKey, float $amount, string $okUrl, string $failUrl,
                                 string $rnd)
    {
        $this->clientId = $clientId;
        $this->storeKey = $storeKey;
        $this->amount = $amount;
        $this->okUrl = $okUrl;
        $this->failUrl = $failUrl;
        $this->rnd = $rnd;
    }

    public static function create(string $clientId, string $storeKey, float $amount, string $okUrl, string $failUrl,
                                  string $rnd): ThreeDPaySecureParameterInterface
    {
        return new ThreeDPaySecureParameter($clientId, $storeKey, $amount, $okUrl, $failUrl, $rnd);
    }

    /**
     * @param string $orderId Gönderilmesse banka tarafından otomatik üretilir
     */
    public function setOrderId(string $orderId): self
    {
        $this->oid = $orderId;
        return $this;
    }

    public function setCardInfo(string $cardNumber, string $expiryDateYear, string $expiryDateMonth, string $cvv,
                                string $cardType): self
    {
        $this->cardNumber = $cardNumber;
        $this->expiryDateYear = $expiryDateYear;
        $this->expiryDateMonth = $expiryDateMonth;
        $this->cvv = $cvv;
        $this->cardType = $cardType;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string $xid Gönderilmezse sistem tarafından üretilir. 20 byte 28 karaktere base64 olarak kodlanmalı
     *
     * @return $this
     */
    public function setXid(string $xid): self
    {
        $this->xid = $xid;
        return $this;
    }

    /**
     * @param string $lang Gönderilmez ise varsayılan 'tr' dir.
     */
    public function setLang(string $lang): self
    {
        $this->lang = $lang;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $userId Kullanıcı takibi için
     *
     * @return $this
     */
    public function setUserId(string $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getParameter(): array
    {
        $parameters = [
            'clientid' => $this->clientId,
            'storetype' => $this->storeType,
            'islemtipi' => $this->authType,
            'amount' => $this->amount,
            //'taksit' => $this->installment,
            'currency' => $this->currency,
            'oid' => $this->oid,
            'okUrl' => $this->okUrl,
            'failUrl' => $this->failUrl,
            'lang' => $this->lang,
            'rnd' => $this->rnd,
            'hashAlgorithm' => $this->hasAlgorithm,
            'pan' => $this->cardNumber,
            'Ecom_Payment_Card_ExpDate_Year' => $this->expiryDateYear,
            'Ecom_Payment_Card_ExpDate_Month' => $this->expiryDateMonth,
            'cv2' => $this->cvv,
            'cardType' => $this->cardType
        ];

        if ($this->description != '')
            $parameters['description'] = $this->description;

        if ($this->email != '')
            $parameters['email'] = $this->email;

        if ($this->userId != '')
            $parameters['userid'] = $this->userId;

        $parameters = $this->sort($parameters);

        $parameters['hash'] = $this->createHash($parameters);

        return $parameters;
    }

    public function createHash(array $parameters): string
    {

        $keys = array_keys($parameters);
        natcasesort($keys);

        $data = [];
        foreach ($keys as $key)
            $data[$key] = $parameters[$key];

        $data['storeKey'] = $this->storeKey;

        foreach ($data as $index => $value)
            $data[$index] = str_replace("|", "\\|", str_replace("\\", "\\\\", $value));

        $hashVal = join('|', $data);

        $calculatedHashValue = hash('sha512', $hashVal);
        return base64_encode(pack('H*', $calculatedHashValue));
    }

    private function sort(array $parameters): array
    {
        $keys = array_keys($parameters);
        natcasesort($keys);

        $data = [];
        foreach ($keys as $key)
            $data[$key] = $parameters[$key];
        return $data;
    }
}