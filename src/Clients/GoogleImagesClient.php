<?php

namespace JohnPaulMontilla\Scrappa\Clients;

use JohnPaulMontilla\Scrappa\RestClient;
use JohnPaulMontilla\Scrappa\Support\ScrappaEndpoint;

class GoogleImagesClient
{
    public function __construct(
        protected RestClient $client
    ) {}
}
