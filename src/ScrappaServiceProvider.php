<?php

namespace JohnPaulMontilla\Scrappa;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ScrappaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         */
        $package
            ->name('scrappa')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        // Register the REST client
        $this->app->singleton(RestClient::class, function ($app) {
            $config = $app['config']->get('scrappa', []);

            return new RestClient($config);
        });

        // Register the main Scrappa client
        $this->app->singleton(ScrappaClient::class, function ($app) {
            return new ScrappaClient(
                $app->make(RestClient::class)
            );
        });
    }
}
