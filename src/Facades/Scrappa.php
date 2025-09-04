<?php

namespace JohnPaulMontilla\Scrappa\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JohnPaulMontilla\Scrappa\ScrappaClient
 * 
 * Facade for accessing Scrappa clients and global methods.
 * 
 * @method static \JohnPaulMontilla\Scrappa\Clients\GoogleMapsClient maps()
 * @method static \JohnPaulMontilla\Scrappa\Clients\GoogleSearchClient search()
 * @method static \JohnPaulMontilla\Scrappa\Clients\GoogleTranslateClient translate()
 * @method static \JohnPaulMontilla\Scrappa\Clients\GoogleImagesClient images()
 * @method static \JohnPaulMontilla\Scrappa\Clients\YouTubeClient youtube()
 * 
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
