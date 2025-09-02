<?php

namespace JohnPaulMontilla\Scrappa;

use InvalidArgumentException;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;

class ScrappaClient
{
    protected RestClient $client;

    public function __construct(RestClient $client)
    {
        $this->client = $client;
    }

    /**
     * Perform an autocomplete on Google Maps
     *
     * @param string $query The search query (required)
     * @return array
     * @throws InvalidArgumentException
     */
    public function autoCompleteGmaps(?string $query = null): array
    {
        if (empty($query)) {
            throw new InvalidArgumentException('Query parameter is required');
        }

        // Build query parameters
        $queryParams = ['query' => $query];

        return $this->client->get(ScrappaEndpoint::MAPS_AUTOCOMPLETE, $queryParams);
    }

    /**
     * Perform an advanced search on Google Maps
     *
     * @param string $query The search query (required)
     * @param array $params Additional parameters (zoom, lat, lon, limit)
     * @param integer $params['zoom'] (required)
     * @return array
     * @throws InvalidArgumentException
     */
    public function advancedSearchGmaps(?string $query = null, array $params = []): array
    {
        if (empty($query)) {
            throw new InvalidArgumentException('The "query" parameter is required.');
        }

        if (empty($params['zoom'])) {
            throw new InvalidArgumentException('The "zoom" parameter is required.');
        }

        // Build query parameters
        $queryParams = ['query' => $query];

        // Add optional parameters if provided
        if (!empty($params)) {
            $queryParams = array_merge($queryParams, $params);
        }

        // Filter out null/empty values except for query
        $queryParams = array_filter($queryParams, function ($value, $key) {
            return in_array($key, ['query', 'zoom'], true) || (!is_null($value) && $value !== '');
        }, ARRAY_FILTER_USE_BOTH);

        return $this->client->get(ScrappaEndpoint::MAPS_ADVANCE_SEARCH, $queryParams);
    }

    /**
     * Retrieve Google Reviews for a specific place.
     *
     * @param string $business_id The search query (required)
     * @param array $params Additional parameters (search, sort, limit, page)
     * @param integer $params['sort'] (required)
     * @return array
     * @throws InvalidArgumentException
     */
    public function googleReviewsGmaps(?string $business_id = null, array $params = []): array
    {
        if (empty($business_id)) {
            throw new InvalidArgumentException('The "business_id" parameter is required.');
        }

        if (empty($params['sort'])) {
            throw new InvalidArgumentException('The "sort" parameter is required.');
        }

        // Build query parameters
        $queryParams = ['business_id' => $business_id];

        // Add optional parameters if provided
        if (!empty($params)) {
            $queryParams = array_merge($queryParams, $params);
        }

        // Filter out null/empty values except for query
        $queryParams = array_filter($queryParams, function ($value, $key) {
            return in_array($key, ['business_id', 'sort'], true) || (!is_null($value) && $value !== '');
        }, ARRAY_FILTER_USE_BOTH);

        return $this->client->get(ScrappaEndpoint::MAPS_GOOGLE_REVIEW, $queryParams);
    }


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
