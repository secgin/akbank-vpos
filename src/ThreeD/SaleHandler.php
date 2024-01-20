<?php

namespace YG\AkbankVPos\ThreeD;

use YG\AkbankVPos\Abstracts\AbstractHandler;
use YG\AkbankVPos\Abstracts\Response;
use YG\AkbankVPos\Abstracts\ThreeD\Sale;

class SaleHandler extends AbstractHandler
{
    public function handle(Sale $request): Response
    {
        $xml= "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>".
            "<CC5Request>".
            "<Name>{$this->config->get('username')}</Name>".
            "<Password>{$this->config->get('password')}</Password>".
            "<ClientId>{$this->config->get('clientId')}</ClientId>".
            "<IPAddress>{$request->getIpAddress()}</IPAddress>".
            "<Mode>P</Mode>".
            "<OrderId>{$request->getOrderId()}</OrderId>".
            "<GroupId></GroupId>".
            "<TransId></TransId>".
            "<UserId></UserId>".
            "<Type>Auth</Type>".
            "<Number>{$request->getMd()}</Number>".
            "<Expires></Expires>".
            "<Cvv2Val></Cvv2Val>".
            "<Total>{$request->getAmount()}</Total>".
            "<Currency>{$request->getCurrency()}</Currency>".
            "<Taksit>{$request->getInstallment()}</Taksit>".
            "<PayerTxnId>{$request->getXid()}</PayerTxnId>".
            "<PayerSecurityLevel>{$request->getEci()}</PayerSecurityLevel>".
            "<PayerAuthenticationCode>{$request->getCavv()}</PayerAuthenticationCode>".
            "<Extra></Extra>".
            "</CC5Request>";


        $result = $this->httpClient->post($this->config->get('serviceUrl'), urlencode($xml));

        return SaleResult::create($result);
    }
}