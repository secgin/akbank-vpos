<?php

namespace YG\AkbankVPos\Abstracts\ThreeDPay;

interface ThreeDPaySecureParameter
{
    public function getParameter() : array;

    public function setOrderId(string $orderId): ThreeDPaySecureParameter;

    /**
     * @param string $cardNumber
     * @param string $expiryDateYear
     * @param string $expiryDateMonth
     * @param string $cvv
     * @param string $cardType 1:Visa, 2:Mastercard
     * @return mixed
     */
    public function setCardInfo(string $cardNumber, string $expiryDateYear, string $expiryDateMonth, string $cvv,
                                string $cardType);
}