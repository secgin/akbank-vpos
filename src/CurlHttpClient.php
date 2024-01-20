<?php

namespace YG\AkbankVPos;

class CurlHttpClient implements Abstracts\HttpClient
{
    public function post(string $serviceUrl, string $data): Abstracts\HttpResult
    {
        $options = [
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_DEFAULT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_POSTFIELDS => $data,
        ];

        $ch = curl_init($serviceUrl);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);

        $requestResult = $result === false
            ? HttpResult::fail(curl_errno($ch), curl_error($ch))
            : HttpResult::success($result);

        curl_close($ch);
        return $requestResult;
    }
}