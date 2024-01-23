<?php

namespace YG\AkbankVPos\Abstracts\ThreeDPay;

interface ThreeDPaySecureParameter
{
    public function getParameter() : array;

    public function setOrderId(string $orderId): ThreeDPaySecureParameter;
}