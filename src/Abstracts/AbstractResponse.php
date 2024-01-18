<?php

namespace YG\AkbankVPos\Abstracts;

abstract class AbstractResponse implements Response
{
    protected bool $success = false;

    protected ?string $errorCode = null;

    protected ?string $errorMessage = null;

    protected ?array $result = null;

    protected function __construct(HttpResult $httpResult)
    {
        if ($httpResult->isSuccess() and $httpResult->getRawResult() != '')
        {
            $result = $this->xmlToArray($httpResult->getRawResult());

            if ($result === false)
            {
                $this->success = false;
                $this->errorMessage = 'Banka tarafından geçersiz bir yanıt alındı.';
            }
            else
            {
                $this->success = true;
                $this->result = $result;
            }
        }
    }

    #region ResponseInterface methods
    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }
    #endregion

    /**
     * @return array|bool
     */
    final protected function xmlToArray(string $xmlData)
    {
        try
        {
            $xml = @simplexml_load_string($xmlData);
            $json = @json_encode($xml);
            return @json_decode($json, true);
        } catch (\Exception $e)
        {
            return false;
        }
    }

    final protected function setError(string $errorCode, string $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->success = false;
    }
}