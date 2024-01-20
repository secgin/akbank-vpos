<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface ThreeDSecureParameter
{
   public function getParameter() : array;

   public function setOrderId(string $orderId): ThreeDSecureParameter;
}