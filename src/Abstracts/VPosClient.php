<?php

namespace YG\AkbankVPos\Abstracts;

use YG\AkbankVPos\Abstracts\ThreeD\Sale;
use YG\AkbankVPos\Abstracts\ThreeD\SaleResult;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureParameter;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureVerify;
use YG\AkbankVPos\Abstracts\ThreeDPay\ThreeDPayResult;
use YG\AkbankVPos\Abstracts\ThreeDPay\ThreeDPaySecureParameter;


/**
 * @method Response|SaleResult sale(Sale $request)
 */
interface VPosClient
{
    public function createThreeDParameter(float  $amount, string $rnd, string $okUrl,
                                          string $failUrl): ThreeDSecureParameter;

    public function createThreeDPayParameter(float  $amount, string $rnd, string $okUrl,
                                          string $failUrl): ThreeDPaySecureParameter;

    public function threeDSecureVerify(array $data): ThreeDSecureVerify;

    public function threeDPayVerify(array $data): ThreeDPayResult;

    public function getConfig(): Config;
}