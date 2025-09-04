<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;

class GoogleSearchClient
{
    public function __construct(
        protected RestClient $client
    ) {}

    /**
     * Perform an autocomplete on Google Maps
     *
     * @param string $query The search query (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function search(?string $query = null, array $params = []): array
    {
        if (empty($query)) {
            throw ScrappaValidationException::missingParameter('query');
        }

        // Build query parameters
        $queryParams = ['query' => $query];

        // Add optional parameters if provided
        if (!empty($params)) {
            $queryParams = array_merge($queryParams, $params);
        }

        // Filter out null/empty except required ones
        $queryParams = array_filter($queryParams, function ($value, $key) {
            return in_array($key, ['query', 'zoom'], true) || (!is_null($value) && $value !== '');
        }, ARRAY_FILTER_USE_BOTH);

        return $this->client->get(ScrappaEndpoint::SEARCH, $queryParams);
    }
}
