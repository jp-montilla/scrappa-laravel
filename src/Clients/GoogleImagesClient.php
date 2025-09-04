<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;

class GoogleImagesClient
{
    public function __construct(
        protected RestClient $client
    ) {}

    /**
     * Perform a google image search on Google
     *
     * @param string $query The search query (required)
     * @param array $params Additional parameter (page)
     * @return array
     * @throws ScrappaValidationException
     */
    public function images(?string $query = null, array $params = []): array
    {
        if (empty($query)) {
            throw ScrappaValidationException::missingParameter('query');
        }

        // Build query parameters
        $queryParams = array_merge(['q' => $query], $params);

        return $this->client->get(ScrappaEndpoint::IMAGES, $queryParams);
    }
}
