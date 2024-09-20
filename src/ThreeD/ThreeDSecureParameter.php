<?php

namespace YG\AkbankVPos\ThreeD;

use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureParameter as ThreeDSecureControlInterface;

final class ThreeDSecureParameter implements ThreeDSecureControlInterface
{
    private string
        $clientId,
        $storeKey,
        $okUrl,
        $failUrl,
        $rnd;

    private float $amount;

    private ?string
        $oid = null,
        $description = null,
        $lang = 'tr',
        $currency = '949',
        $email = null,
        $userId = null;

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
                                  string $rnd): ThreeDSecureControlInterface
    {
        return new ThreeDSecureParameter($clientId, $storeKey, $amount, $okUrl, $failUrl, $rnd);
    }

    /**
     * @param string $orderId Gönderilmesse banka tarafından otomatik üretilir
     */
    public function setOrderId(string $orderId): self
    {
        $this->oid = $orderId;
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
            'amount' => $this->amount,
            'okUrl' => $this->okUrl,
            'failUrl' => $this->failUrl,
            'storetype' => '3d',
            'rnd' => $this->rnd,
            'hash' => $this->createHash(),
            'currency' => $this->currency
        ];

        if ($this->oid != '')
            $parameters['oid'] = $this->oid;

        if ($this->description != '')
            $parameters['description'] = $this->description;

        if ($this->lang != '')
            $parameters['lang'] = $this->lang;

        if ($this->email != '')
            $parameters['email'] = $this->email;

        if ($this->userId != '')
            $parameters['userid'] = $this->userId;

        return $parameters;
    }

    public function createHash(): string
    {
        $data = [
            $this->clientId,
            ($this->oid ?? ''),
            $this->amount,
            $this->okUrl,
            $this->failUrl,
            $this->rnd,
            $this->storeKey
        ];
        foreach ($data as $index => $value)
            $data[$index] = str_replace("|", "\\|", str_replace("\\", "\\\\", $value));

        natcasesort($data);
        $hashVal = join('|', $data);

        $calculatedHashValue = hash('sha512', $hashVal);
        return base64_encode(pack('H*', $calculatedHashValue));
    }
}