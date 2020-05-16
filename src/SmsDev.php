<?php

namespace lucasgiovanny\SmsDev;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use lucasgiovanny\SmsDev\Exceptions\CouldNotSendNotification;

class SmsDev
{
    /**
     * @var string SMS Dev API url.
     */
    protected $apiUrl = "https://api.smsdev.com.br/";

    protected $http;

    protected $apiKey;

    public function __construct(string $apiKey = null, HttpClient $http = null)
    {
        $this->apiKey = $apiKey;
        $this->http = $http;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function httpClient(): HttpClient
    {
        return $this->http ?? new HttpClient();
    }

    public function sendMessage(array $params)
    {
        return $this->sendRequest('send', $params);
    }

    public function sendRequest(string $endpoint, array $params)
    {
        if (empty($this->apiKey)) {
            throw CouldNotSendNotification::apiKeyNotProvided();
        }

        $params['key'] = $this->apiKey;

        try {
            return $this->httpClient()->get($this->apiUrl . $endpoint, [
                'query' => $params
            ]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }
    }
}
