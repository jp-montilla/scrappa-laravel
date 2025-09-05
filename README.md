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
- 📝 Google Single Review

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

#### 📝 Google Single Review
```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Get Google Reviews (requires business_id)
$response = Scrappa::maps()->googleSingleReview([
    'review_id' => 'ChZDSUhNMG9nS0VJQ0FnSUNRaE4tOEhREAE',
    'business_id' => '0x3397c9fbfdca4c77:0x1f2e4f2f0f88b8e9'
]);
```
> ##### 📌 Sample API Response
> See full response example here: [google-single-review.json](./examples/google-single-review.json)


### Google Search API Support
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

### Google Translate API Support
---

#### 🈯 Translate Text

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Translate Text (requires all parameters)
$response = Scrappa::googleSearch()->search([
    'text' => 'Good Morning',   // required
    'source' => 'en',           // required
    'target' => 'tl',           // required
]);
```
> ##### 📌 Sample API Response
> See full response example here: [translate-text.json](./examples/translate-text.json)

### Google Images API Support
---

#### 🖼️ Image Search

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Google Image search (requires query parameter)
$response = $response = Scrappa::googleImages()->images('Nice dog');

// Web Search with additional optional parameter
$response = Scrappa::googleImages()->images("Nice dog", [
    'page' => 2, // optional
]);
```
> ##### 📌 Sample API Response
> See full response example here: [images-result.json](./examples/images-result.json)

### Youtube API Support
---

#### 📹 Video Info

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Google Image search (requires query parameter)
$response = $response = Scrappa::youtube()->video('https://youtu.be/sUtRcpma8iU?si=q9clbqmNDD6fJFv4');
```
> ##### 📌 Sample API Response
> See full response example here: [youtube.json](./examples/youtube.json)


### 🔧 Advanced Usage
---
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
---
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
---
#### Autocomplete – Google Maps API
- `query` *(required, string)*: The partial search term to get autocomplete suggestions for  

#### Advanced Search – Google Maps API
- `query` *(required, string)*: The search term that will be used by the API  
- `zoom` *(required, integer)*: The level of detail displayed on the map (minimum value: 3)  
- `lat` *(optional, float)*: Latitude coordinate for the search center  
- `lon` *(optional, float)*: Longitude coordinate for the search center  
- `limit` *(optional, integer)*: Maximum number of results to return  

#### Simple Search – Google Maps API
- `query` *(required, string)*: The search term that the API will use  

#### Google Reviews – Google Maps API
- `business_id` *(required, string)*: The unique Google Business ID (format: `0x...:0x...`)  
- `sort` *(required, integer)*: Sort order for reviews (`1=newest`, `2=highest`, `3=lowest`)  
- `search` *(optional, string)*: Filter reviews by search term  
- `limit` *(optional, integer)*: Maximum number of reviews to return  
- `page` *(optional, string)*: Page token for pagination  

#### Business Details – Google Maps API
- `business_id` *(required, string)*: The unique Google Business ID (format: `0x...:0x...`) that identifies a specific place or business on Google Maps 

#### Google Single Review – Google Maps API
- `review_id` *(required, string)*: The Google review ID (e.g. ChZDSUhNMG9nS0VJQ0FnSUNRaE4tOEhREAE)
- `business_id` *(required, string)*: The Google Maps business ID (e.g. 0x47bd0ea521300001:0x918691af860a8cc0)

#### Google Search – Google Search API
- `query` *(required, string)*: The stuff you're searching for on Google Search.
- `language` *(optional, string)*: Language code for search results (2-letter code)(e.g., `"en"`, `"tl"`)  
- `amount` *(optional, integer)*: Number of results per page (default: 10)  
- `page` *(optional, integer)*: The page number you want in the result (starting from 0). 
- `as_qdr` *(optional, string)*: Time filter for results  
  - `h1` = past hour  
  - `h4` = past 4 hours  
  - `d` = past day  
  - `w` = past week  
  - `m` = past month  
  - `y` = past year  
- `type` *(optional, string)*: Type of search  
  - `news` = news results
  - `isch` = images
  - `vid` = videos
> 👉 See the full list of accepted values here: [Google Cloud Translate Supported Languages](https://cloud.google.com/translate/docs/languages#try-it-for-yourself) 

#### Google Translate – Google Translate API
- `text` *(required, string)*: The word or phrase to translate  
- `source` *(required, string)*: The source language of the text  
- `target` *(required, string)*: The target language to translate into  

> Example:
> If you want to translate `"Good Morning"` from English to German:  
> `text`: `"Good Morning"`  
> `source`: `"en"`  
> `target`: `"de"`  
> 👉 See the full list of accepted values here: [Google Cloud Translate Supported Languages](https://cloud.google.com/translate/docs/languages#try-it-for-yourself)

#### Google Images – Google Images API
- `q` *(required, string)*: The search term that will be used to scrape the images.
- `page` *(optional, integer)*: Specifies which page of search results to retrieve.Usage:page=1 or omitted - Returns the first page of resultspage=2 - Returns the second page of resultspage=3 - Returns the third page of results

#### YouTube Video Info – YouTube API
- `url` *(required, string)*: The URL of the YouTube Video
