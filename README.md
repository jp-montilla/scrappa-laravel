# Scrappa Laravel Package

A simple and clean Laravel wrapper for the Scrappa API, allowing you to make HTTP requests with parameters to interact with all Scrappa API endpoints. It's a pure API client package with no database dependencies.

## Features

- 🚀 Simple and clean API client
- 🔧 Easy configuration
- 📦 No database dependencies
- 🎯 Google Maps advanced search
- 💡 Laravel Facade support

## Installation

You can install the package via composer:

```bash
composer require johnpaulmontilla/scrappa
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="JohnPaulMontilla\Scrappa\ScrappaServiceProvider"
```

## Configuration

Add your Scrappa API credentials to your `.env` file:

```env
SCRAPPA_API_KEY=your_api_key_here
SCRAPPA_BASE_URL=https://app.scrappa.co/api
SCRAPPA_TIMEOUT=30
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('SCRAPPA_API_KEY', ''),
    'base_url' => env('SCRAPPA_BASE_URL', 'https://app.scrappa.co/api'),
    'timeout' => env('SCRAPPA_TIMEOUT', 30),
    'defaults' => [
        'zoom' => 5,
        'limit' => 10,
    ],
];
```

## Usage

### Using the Facade

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Basic search (only query required)
$response = Scrappa::advanceSearchGmaps('Manila');

// Advanced search with optional parameters
$response = Scrappa::advanceSearchGmaps('Manila', [
    'zoom' => 5,
    'lat' => 14.5995,
    'lon' => 120.9842,
    'limit' => 10
]);

// Access the results
echo "Query: " . $response['query'] . "\n";
echo "Found " . count($response['results']['items']) . " results\n";

foreach ($response['results']['items'] as $result) {
    echo "Name: " . $result['name'] . "\n";
    echo "Address: " . $result['full_address'] . "\n";
    echo "Rating: " . ($result['rating'] ?? 'N/A') . "\n";
    echo "Website: " . ($result['website'] ?? 'N/A') . "\n";
    echo "---\n";
}
```

### Using Dependency Injection

```php
use JohnPaulMontilla\Scrappa\ScrappaClient;

class MyController extends Controller
{
    public function __construct(private ScrappaClient $scrappa)
    {
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $response = $this->scrappa->advanceSearchGmaps($query);
        
        return response()->json($response);
    }
}
```

### Generic GET Requests

For other API endpoints that support GET requests:

```php
// GET request
$response = Scrappa::get('/other-endpoint', [
    'param1' => 'value1',
    'param2' => 'value2'
]);
```

### Dynamic Configuration

You can configure the client at runtime:

```php
$response = Scrappa::setApiKey('your-api-key')
    ->setBaseUrl('https://custom-api.com')
    ->setTimeout(60)
    ->addHeader('Custom-Header', 'value')
    ->advanceSearchGmaps('Manila');
```

## Response Structure

The API returns a simple PHP array with the following structure:

```php
[
    'query' => 'Manila',
    'results' => [
        'items' => [
            [
                'name' => 'Manila',
                'rating' => 4.5,
                'review_count' => 100,
                'website' => 'http://example.com',
                'full_address' => 'Metro Manila, Philippines',
                'latitude' => 14.5995,
                'longitude' => 120.9842,
                'phone_numbers' => [],
                'photos_sample' => [],
                // ... and many more fields
            ]
        ]
    ]
]
```

## Error Handling

The package throws `InvalidArgumentException` for:
- Missing required query parameter
- Missing API key

```php
try {
    $response = Scrappa::advanceSearchGmaps('Manila');
} catch (InvalidArgumentException $e) {
    // Handle the error
    echo "Error: " . $e->getMessage();
}
```

## Available Parameters

For Google Maps advanced search, you can use these parameters:

- `query` (required): The search term that will be used by the API (string)
- `zoom` (optional): The level of detail displayed on the map (integer)
- `lat` (optional): Latitude coordinate for the search center (float)
- `lon` (optional): Longitude coordinate for the search center (float)  
- `limit` (optional): Maximum number of results to return (integer)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
