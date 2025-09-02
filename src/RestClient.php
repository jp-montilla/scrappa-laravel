<?php

namespace JohnPaulMontilla\Scrappa;

use InvalidArgumentException;

class RestClient
{
    protected string $baseUrl;
    protected string $apiKey;
    protected int $timeout;
    protected array $defaultHeaders;

    public function __construct(array $config = [])
    {
        $this->baseUrl = rtrim($config['base_url'] ?? 'https://app.scrappa.co/api', '/');
        $this->apiKey = $config['api_key'] ?? '';
        $this->timeout = $config['timeout'] ?? 30;

        $this->defaultHeaders = [
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: Scrappa-Laravel/1.0',
        ];
    }

    /**
     * Make a GET request
     *
     * @param string $endpoint
     * @param array $params
     * @return array
     * @throws InvalidArgumentException
     */
    public function get(string $endpoint, array $params = []): array
    {
        if (empty($this->apiKey)) {
            throw new InvalidArgumentException('API key is required. Please set it in config or pass it to constructor');
        }

        $url = $this->buildUrl($endpoint, $params);
        $headers = $this->buildHeaders();

        return [
            'parameters' => $params,
            'results' => $this->makeCurlRequest($url, $headers),
        ];

        return $this->makeCurlRequest($url, $headers);
    }

    /**
     * Build the full URL with query parameters
     *
     * @param string $endpoint
     * @param array $params
     * @return string
     */
    protected function buildUrl(string $endpoint, array $params = []): string
    {
        $endpoint = ltrim($endpoint, '/');
        $url = $this->baseUrl . '/' . $endpoint;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Build request headers
     *
     * @return array
     */
    protected function buildHeaders(): array
    {
        $headers = $this->defaultHeaders;

        if (!empty($this->apiKey)) {
            $headers[] = 'x-api-key: ' . $this->apiKey;
        }

        return $headers;
    }

    /**
     * Make a cURL request
     *
     * @param string $url
     * @param array $headers
     * @return array
     * @throws InvalidArgumentException
     */
    protected function makeCurlRequest(string $url, array $headers): array
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'Scrappa-Laravel/1.0',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new InvalidArgumentException('cURL error: ' . $error);
        }

        if ($httpCode >= 400) {
            throw new InvalidArgumentException(
                'API request failed: ' . $httpCode . ' - ' . $response
            );
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $data ?? [];
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
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
        $this->baseUrl = rtrim($baseUrl, '/');
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
        $this->timeout = $timeout;
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
        $this->defaultHeaders[] = $key . ': ' . $value;
        return $this;
    }

    /**
     * Get the current API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the current base URL
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
