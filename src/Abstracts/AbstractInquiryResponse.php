<?php

namespace YG\AkbankVPos\Abstracts;

class AbstractInquiryResponse extends AbstractResponse
{
    protected function __construct(HttpResult $httpResult)
    {
        parent::__construct($httpResult);

        if ($httpResult->isSuccess())
        {
            $responseCode = $this->result['ResponseInfo']['ResponseCode'] ?? '';
            if ($responseCode != '0000')
                $this->setError($responseCode, $this->result['ResponseInfo']['ResponseMessage'] ?? '');
            else
                $this->success = true;
        }
    }
}