<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;

class GoogleTranslateClient
{
    public function __construct(
        protected RestClient $client
    ) {}

    /**
     * Perform an google translate on Google
     *
     * @param array $params The text, source and target translation (required)
     * @return array
     * @throws ScrappaValidationException
     */
    public function translate(array $params = []): array
    {
        if (empty($params['text'])) {
            throw ScrappaValidationException::missingParameter('text');
        }

        if (empty($params['source'])) {
            throw ScrappaValidationException::missingParameter('source');
        }

        if (empty($params['target'])) {
            throw ScrappaValidationException::missingParameter('target');
        }

        return $this->client->get(ScrappaEndpoint::TRANSLATE, $params);
    }
}
