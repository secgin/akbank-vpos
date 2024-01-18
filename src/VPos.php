<?php

namespace YG\AkbankVPos;

use YG\AkbankVPos\Abstracts\AbstractHandler;
use YG\AkbankVPos\Abstracts\Config;
use YG\AkbankVPos\Abstracts\HttpClient;
use YG\AkbankVPos\Abstracts\Response;
use YG\AkbankVPos\Abstracts\VPosClient;
class VPos implements VPosClient
{
    private Config $config;

    private HttpClient $httpClient;

    private array $requestClasses = [
        'threeDSecureControl' => EnrollmentControlHandler::class,
        'sale' => SaleHandler::class,
        'cancel' => CancelHandler::class,
        'refund' => RefundHandler::class,
        'revers' => ReversHandler::class,
        'settlementDetail' => SettlementDetailHandler::class,
        'settlement' => SettlementHandler::class,
        'search' => SearchHandler::class,
        'succeededOpenBatchTransactions' => SucceededOpenBatchTransactionsHandler::class
    ];

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->httpClient = new CurlHttpClient();
    }

    public function __call($name, $arguments)
    {
        if ($this->hasRequestClass($name))
            return $this->handle($name, $arguments[0] ?? null);

        throw new \Exception('Method not found');
    }

    #region Handler Methods
    private function getRequestHandler($name)
    {
        $requestHandlerClass = $this->requestClasses[$name];
        $handler = new $requestHandlerClass();

        if ($handler instanceof AbstractHandler)
        {
            $handler->setConfig($this->config);
            $handler->setHttpClient($this->httpClient);
        }
        return $handler;
    }


    private function hasRequestClass(string $name): bool
    {
        return isset($this->requestClasses[$name]);
    }

    private function handle(string $requestName, $request): Response
    {
        return $this->getRequestHandler($requestName)->handle($request);
    }
    #endregion
}