# Scrappa Laravel Package

A simple and clean Laravel wrapper for the Scrappa API, allowing you to make HTTP requests with parameters to interact with all Scrappa API endpoints. It's a pure API client package with no database dependencies.

## ✨ Features

🚀 Simple and clean API client
🔧 Easy configuration
📦 No database dependencies
💡 Laravel Facade support

### Google Maps API Support
- 🎯 Advanced Search
- 🔍 Autocomplete 
- 🗺️ Simple Search 
- ⭐ Google Reviews
- 🏢 Business Details

### Google Search API Support
- 🌐 Web Search

### Google Translate API Support
- 🈯 Translate Text

### Google Images API Support
- 🖼️ Image Search

### YouTube API Support
- 📹 Video Info 


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
];
```

## ⚡ Usage

#### Using the Facade

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Advanced Search (requires both query and zoom parameter)
$response = $response = Scrappa::maps()->advancedSearch('Manila', [
    'zoom' => 5, // required
]);

// Advanced search with additional optional parameters
$response = Scrappa::maps()->advancedSearch('Manila', [
    'zoom' => 5,          // required
    'lat' => 14.5995,     // optional
    'lon' => 120.9842,    // optional
    'limit' => 10         // optional
]);

// Access the results
echo "Query: " . $response['parameters']['query'] . "\n";
echo "Found " . count($response['results']['items']) . " results\n";

foreach ($response['results']['items'] as $result) {
    echo "Name: " . $result['name'] . "\n";
    echo "Address: " . $result['full_address'] . "\n";
    echo "Rating: " . ($result['rating'] ?? 'N/A') . "\n";
    echo "Website: " . ($result['website'] ?? 'N/A') . "\n";
    echo "---\n";
}
```

#### Using Dependency Injection

```php
use JohnPaulMontilla\Scrappa\ScrappaClient;

class MyController extends Controller
{
    public function __construct(private ScrappaClient $scrappa) {}

    public function search(Request $request)
    {
        $query = $request->input('query');
        $zoom = $request->input('zoom');
        $response = $this->scrappa->maps()->advancedSearch($query, ['zoom' => $zoom]);
        
        return response()->json($response);
    }
}
```

### 📍 Google Maps API Support
---
#### 🔍 Autocomplete

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Autocomplete search with only the query parameter
$response = Scrappa::maps()->autoComplete('Manil');
```
> ##### 📌 Sample API Response
> See full response example here: [autocomplete.json](./examples/autocomplete.json)

#### 🎯 Advanced Search

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Advanced Search (requires both query and zoom parameter)
$response = $response = Scrappa::maps()->advancedSearch('Manila', [
    'zoom' => 5,
]);

// Advanced search with additional optional parameters
$response = Scrappa::maps()->advancedSearch('Manila', [
    'zoom' => 5,          // required
    'lat' => 14.5995,     // optional
    'lon' => 120.9842,    // optional
    'limit' => 10         // optional
]);
```
> ##### 📌 Sample API Response
> See full response example here: [advanced-search.json](./examples/advanced-search.json)


#### 🗺️ Simple Search 

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Autocomplete search with only the query parameter
$response = Scrappa::maps()->simpleSearch('Restaurant in Intramuros, Manila');
```

> ##### 📌 Sample API Response
> See full response example here: [simple-search.json](./examples/simple-search.json)

#### ⭐ Google Reviews

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Get Google Reviews (requires business_id and sort)
$response = Scrappa::maps()->googleReviews('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2', [
    'sort'  => 1,  // required
    'limit' => 1   // optional
]);

// Get Google Reviews with additional optional filters
$response = Scrappa::maps()->googleReviews('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2',[
    'sort' => 1,                    // required
    'search' => 'Place is good',    // optional
    'limit' => 4,                   // optional
    'page' => 'CAESY0NBR....'       // optional
]);
```
> ##### 📌 Sample API Response
> See full response example here: [google-reviews.json](./examples/google-reviews.json)

#### 🏢 Business Details  

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Get Google Reviews (requires business_id)
$response = Scrappa::maps()->businessDetails('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2');
```
> ##### 📌 Sample API Response
> See full response example here: [business-details.json](./examples/business-details.json)


### 🔎 Google Search API Support
---

#### 🌐 Web Search

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Web Search (requires query parameter)
$response = $response = Scrappa::googleSearch()->search('Nice dog');

// Web Search with additional optional parameters
$response = Scrappa::googleSearch()->search("Nice dog", [
    'language' => 'tl', // optional
    'amount' => 20,     // optional
    'page' => 1,        // optional
    'as_qdr' => 'h4'    // optional
    'type' => 'isch'    // optional
]);
```
> ##### 📌 Sample API Response
> See full response example here: [web-search.json](./examples/web-search.json)


### 🔧 Advanced Usage

#### Generic GET Requests

For other API endpoints that support GET requests:

```php
// GET request
$response = Scrappa::get('/other-endpoint', [
    'param1' => 'value1',
    'param2' => 'value2'
]);
```

#### Dynamic Configuration

You can configure the client at runtime:

```php
$response = Scrappa::setApiKey('your-api-key')
    ->setBaseUrl('https://custom-api.com')
    ->setTimeout(60)
    ->addHeader('Custom-Header', 'value')
    ->maps()
    ->advancedSearch('Manila', ['zoom' => 3]);
```

### Error Handling

The package uses custom exceptions under the `JohnPaulMontilla\Scrappa\Exceptions` namespace.

- `ScrappaValidationException` – Missing or invalid parameters  
- `ScrappaAuthException` – Authentication issues (e.g., missing/invalid API key)  
- `ScrappaHttpException` – Failed HTTP requests (4xx/5xx responses)  

#### Example

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaValidationException;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaAuthException;
use JohnPaulMontilla\Scrappa\Exceptions\ScrappaHttpException;

try {
    $response = Scrappa::maps()->advancedSearch('Manila', ['zoom' => 3]);
} catch (ScrappaValidationException $e) {
    echo "Validation Error: " . $e->getMessage();
} catch (ScrappaAuthException $e) {
    echo "Authentication Error: " . $e->getMessage();
} catch (ScrappaHttpException $e) {
    echo "HTTP Error: " . $e->getMessage();
}
```

### Available Parameters

For Autocomplete - Google Maps API, you only need query parameter:

- `query` (required): The partial search term to get autocomplete suggestions for (string)


For Advanced Search - Google Maps API, you can use these parameters:

- `query` (required): The search term that will be used by the API (string)
- `zoom` (required): The level of detail displayed on the map. Minimum value is 3 (integer)
- `lat` (optional): Latitude coordinate for the search center (float)
- `lon` (optional): Longitude coordinate for the search center (float)  
- `limit` (optional): Maximum number of results to return (integer)

For Simple Search - Google Maps API, you only need query parameter:

- `query` (required): The search term that the API will use. (string)


For Google Review - Google Maps API, you can use these parameters:

- `business_id` (required): The unique Google Business ID (format: 0x...:0x...) (string)
- `sort` (required): Sort order for reviews (1=newest, 2=highest, 3=lowest) (integer)
- `search` (optional): Filter reviews by search term (string)
- `limit` (optional): Maximum number of reviews to return (integer)
- `page` (optional): Page token for pagination (string)  

For Business Details - Google Maps API, you only need query parameter:

- `business_id` (required): The unique Google Business ID (format: 0x...:0x...) that identifies a specific place or business on Google Maps. (string)

