<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;

class YouTubeClient
{
    public function __construct(
        protected RestClient $client
    ) {}

    /**
     * Perform a youtube vide info search on Youtube
     *
     * @param string $url The search url (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function video(?string $url = null): array
    {
        if (empty($url)) {
            throw ScrappaValidationException::missingParameter('url');
        }

        // Build query parameters
        $queryParams = ['url' => $url];

        return $this->client->get(ScrappaEndpoint::YOUTUBE, $queryParams);
    }
}
