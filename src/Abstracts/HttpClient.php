<?php

namespace YG\AkbankVPos\Abstracts;

interface HttpClient
{
    public function post(string $serviceUrl, string $data): HttpResult;
}