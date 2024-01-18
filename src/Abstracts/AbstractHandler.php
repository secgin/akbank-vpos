<?php

namespace YG\AkbankVPos\Abstracts;


abstract class AbstractHandler
{
    protected Config $config;

    protected HttpClient $httpClient;

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function setHttpClient(HttpClient $httpClient): void
    {
        $this->httpClient = $httpClient;
    }
}