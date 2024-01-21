<?php

namespace YG\AkbankVPos\ThreeD;

use YG\AkbankVPos\Abstracts\AbstractResponse;
use YG\AkbankVPos\HttpResult;

class SaleResult extends AbstractResponse implements \YG\AkbankVPos\Abstracts\ThreeD\SaleResult
{
    private string
        $response,
        $orderId,
        $transId;

    protected function __construct(\YG\AkbankVPos\Abstracts\HttpResult $httpResult)
    {
        parent::__construct($httpResult);

        $this->response = '';
        $this->orderId = '';
        $this->transId = '';

        if ($this->isSuccess())
        {
            $result = $this->getResult();
            $this->response = $result['Response'] ?? '';

            $orderId = $result['OrderId'] ?? '';
            if (is_string($orderId))
                $this->orderId = $orderId;

            $transId = $result['TransId'] ?? '';
            if (is_string($transId))
                $this->transId = $transId;

            $errMsg = $result['ErrMsg'] ?? null;
            if (is_string($errMsg))
                $this->errorMessage = $errMsg;
        }
    }

    public static function create(HttpResult $httpResult): SaleResult
    {
        return new SaleResult($httpResult);
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getTransId(): string
    {
        return $this->transId;
    }

    public function isPaymentSuccess(): bool
    {
        return $this->response == 'Approved';
    }
}