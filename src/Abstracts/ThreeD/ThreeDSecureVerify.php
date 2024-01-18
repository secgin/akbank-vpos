<?php

namespace YG\AkbankVPos\Abstracts\ThreeD;

interface ThreeDSecureVerify
{
    public function getClientId(): string;

    public function getOid(): string;

    public function getPAResSyntaxOK(): string;

    public function getPAResVerified(): string;

    public function getVersion(): string;

    public function getMerchantId(): string;

    public function getMdStatus(): string;

    public function getMdErrorMsg(): string;

    public function getTxstatus(): string;

    public function getIReqCode(): string;

    public function getIReqDetail(): string;

    public function getVendorCode(): string;

    public function getEci(): string;

    public function getCavv(): string;

    public function getCavvAlgorithm(): string;

    public function getMd(): string;

    public function getRnd(): string;

    public function getHashParams(): string;
}