<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use InvalidArgumentException;
use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;

class GoogleMapsClient
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
    public function autoComplete(?string $query = null): array
    {
        if (empty($query)) {
            throw ScrappaValidationException::missingParameter('query');
        }

        return $this->client->get(
            ScrappaEndpoint::MAPS_AUTOCOMPLETE,
            ['query' => $query]
        );
    }

    /**
     * Perform an advanced search on Google Maps
     *
     * @param string $query The search query (required)
     * @param array $params Additional parameters (zoom, lat, lon, limit)
     * @param integer $params['zoom'] (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function advancedSearch(?string $query = null, array $params = []): array
    {
        if (empty($query)) {
            throw ScrappaValidationException::missingParameter('query');
        }

        if (empty($params['zoom'])) {
            throw ScrappaValidationException::missingParameter('zoom');
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

        return $this->client->get(ScrappaEndpoint::MAPS_ADVANCED_SEARCH, $queryParams);
    }


    /**
     * Retrieve Google Reviews for a specific place.
     *
     * @param string $business_id The search query (required)
     * @param array $params Additional parameters (search, sort, limit, page)
     * @param integer $params['sort'] (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function googleReviews(?string $business_id = null, array $params = []): array
    {
        if (empty($business_id)) {
            throw ScrappaValidationException::missingParameter('business_id');
        }

        if (empty($params['sort'])) {
            throw ScrappaValidationException::missingParameter('sort');
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
     * Retrieve Google Reviews for a specific place.
     *
     * @param string $business_id The search query (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function businessDetails(?string $business_id = null): array
    {
        if (empty($business_id)) {
            throw ScrappaValidationException::missingParameter('business_id');
        }

        return $this->client->get(
            ScrappaEndpoint::MAPS_BUSINESS_DETAILS,
            ['business_id' => $business_id]
        );
    }
}
