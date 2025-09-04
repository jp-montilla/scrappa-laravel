<?php

namespace JohnPaulMontilla\Scrappa;

use JohnPaulMontilla\Scrappa\Clients\GoogleMapsClient;
use JohnPaulMontilla\Scrappa\Clients\GoogleSearchClient;
use JohnPaulMontilla\Scrappa\Clients\GoogleTranslateClient;
use JohnPaulMontilla\Scrappa\Clients\GoogleImagesClient;
use JohnPaulMontilla\Scrappa\Clients\YouTubeClient;

class ScrappaClient
{
    public function __construct(
        protected RestClient $client
    ) {}

    // -----------------------------
    // Sub-clients
    // -----------------------------
    public function maps(): GoogleMapsClient
    {
        return new GoogleMapsClient($this->client);
    }

    public function search(): GoogleSearchClient
    {
        return new GoogleSearchClient($this->client);
    }

    public function translate(): GoogleTranslateClient
    {
        return new GoogleTranslateClient($this->client);
    }

    public function images(): GoogleImagesClient
    {
        return new GoogleImagesClient($this->client);
    }

    public function youtube(): YouTubeClient
    {
        return new YouTubeClient($this->client);
    }

    // -----------------------------
    // Global utilities
    // -----------------------------

    /**
     * Generic method to make GET requests with parameters
     *
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @return array
     */
    public function get(string $endpoint, array $params = []): array
    {
        return $this->client->get($endpoint, $params);
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey): self
    {
        $this->client->setApiKey($apiKey);
        return $this;
    }

    /**
     * Set the base URL
     *
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->client->setBaseUrl($baseUrl);
        return $this;
    }

    /**
     * Set the timeout
     *
     * @param int $timeout
     * @return $this
     */
    public function setTimeout(int $timeout): self
    {
        $this->client->setTimeout($timeout);
        return $this;
    }

    /**
     * Add a custom header
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addHeader(string $key, string $value): self
    {
        $this->client->addHeader($key, $value);
        return $this;
    }

    /**
     * Get the underlying REST client
     *
     * @return RestClient
     */
    public function getClient(): RestClient
    {
        return $this->client;
    }
}
