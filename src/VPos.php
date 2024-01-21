<?php

namespace YG\AkbankVPos;

use Exception;
use YG\AkbankVPos\Abstracts\AbstractHandler;
use YG\AkbankVPos\Abstracts\Config;
use YG\AkbankVPos\Abstracts\HttpClient;
use YG\AkbankVPos\Abstracts\Response;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureParameter;
use YG\AkbankVPos\Abstracts\ThreeD\ThreeDSecureVerify;
use YG\AkbankVPos\Abstracts\VPosClient;
use YG\AkbankVPos\ThreeD\SaleHandler;

class VPos implements VPosClient
{
    private Config $config;

    private HttpClient $httpClient;

    private array $requestClasses = [
        'sale' => SaleHandler::class
    ];

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->httpClient = new CurlHttpClient();
    }

    public function createThreeDParameter(float  $amount, string $rnd, string $okUrl,
                                          string $failUrl): ThreeDSecureParameter
    {
        return \YG\AkbankVPos\ThreeD\ThreeDSecureParameter::create(
            $this->config->get('clientId'),
            $this->config->get('storeKey'),
            $amount,
            $okUrl,
            $failUrl,
            $rnd);
    }

    public function threeDSecureVerify(array $data): ThreeDSecureVerify
    {
        return \YG\AkbankVPos\ThreeD\ThreeDSecureVerify::create($data, $this->config->get('storeKey'));
    }

    public function getConfig(): Config
    {
        return $this->config;
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

    #region Magic Methods
    /**
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if ($this->hasRequestClass($name))
            return $this->handle($name, $arguments[0] ?? null);

        throw new Exception('Method not found');
    }
    #endregion
}