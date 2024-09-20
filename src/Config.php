<?php

namespace YG\AkbankVPos;

use http\Encoding\Stream;

/**
 * @method Config clientId(string $clientId)
 * @method Config username(string $username)
 * @method Config password(string $password)
 * @method Config storeKey(string $storeKey)
 * @method Config activeTestMode()
 */
class Config implements Abstracts\Config
{
    private array $items = [];

    private array $methods = [
        'clientId',
        'username',
        'password',
        'storeKey'
    ];

    private function __construct(array $config)
    {
        $this->items = $config;
        $this->loadServices();
    }

    public static function create(array $config = []): self
    {
        return new self($config);
    }

    public function set(string $key, $value): Abstracts\Config
    {
        $this->items[$key] = $value;
        return $this;
    }

    public function get(string $key): string
    {
        return $this->items[$key] ?? '';
    }

    public function __call($name, $arguments)
    {
        if ($name == 'activeTestMode')
        {
            $this->set('testMode', true);
            $this->loadTestService();
            return $this;
        }

        if (in_array($name, $this->methods) === false)
            throw new \Exception('Method not found!');

        if (count($arguments) === 0)
            return $this->get($name);

        return $this->set($name, $arguments[0]);
    }

    private function loadServices(): void
    {
        $serviceUrl = 'https://www.sanalakpos.com/fim/api';
        $threeDServiceUrl = 'https://www.sanalakpos.com/fim/est3Dgate';

        $this->set('serviceUrl', $serviceUrl);
        $this->set('threeDServiceUrl', $threeDServiceUrl);
    }

    private function loadTestService()
    {
        $serviceUrl = 'https://entegrasyon.asseco-see.com.tr/fim/api';
        $threeDServiceUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dgate';

        $this->set('serviceUrl', $serviceUrl);
        $this->set('threeDServiceUrl', $threeDServiceUrl);
    }
}