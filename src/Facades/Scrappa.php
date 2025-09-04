<?php

namespace JohnPaulMontilla\Scrappa\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JohnPaulMontilla\Scrappa\ScrappaClient
 * 
 * @method static array advancedSearchGmaps(?string $query = null, array $params = [])
 * @method static array autoCompleteGmaps(?string $query = null)
 * @method static array googleReviewsGmaps(?string $query = null, array $params = [])
 * @method static array businessDetailsGmaps(?string $query = null)
 * @method static array get(string $endpoint, array $params = [])
 * @method static \JohnPaulMontilla\Scrappa\ScrappaClient setApiKey(string $apiKey)
 * @method static \JohnPaulMontilla\Scrappa\ScrappaClient setBaseUrl(string $baseUrl)
 * @method static \JohnPaulMontilla\Scrappa\ScrappaClient setTimeout(int $timeout)
 * @method static \JohnPaulMontilla\Scrappa\ScrappaClient addHeader(string $key, string $value)
 * @method static \JohnPaulMontilla\Scrappa\RestClient getClient()
 */
class Scrappa extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JohnPaulMontilla\Scrappa\ScrappaClient::class;
    }
}
