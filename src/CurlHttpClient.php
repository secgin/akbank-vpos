<?php

namespace YG\AkbankVPos;

class CurlHttpClient implements Abstracts\HttpClient
{
    public function post(string $serviceUrl, string $data): Abstracts\HttpResult
    {
        $options = [
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => ["Content-Type" => "application/x-www-form-urlencoded"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
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