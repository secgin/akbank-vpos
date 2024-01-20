<?php

namespace YG\AkbankVPos\Abstracts;

use YG\AkbankVPos\Abstracts\ThreeD\Sale;
use YG\AkbankVPos\Abstracts\ThreeD\SaleResult;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureParameter;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureVerify;


/**
 * @method Response|SaleResult sale(Sale $request)
 */
interface VPosClient
{
    public function createThreeDParameter(float $amount, string $rnd) : ThreeDSecureParameter;

    public function threeDSecureVerify(array $data): ThreeDSecureVerify;
}