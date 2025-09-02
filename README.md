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

### Using the Facade

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Advanced Search (requires both query and zoom parameter)
$response = $response = Scrappa::advancedSearchGmaps('Manila', [
    'zoom' => 5, // required
]);

// Advanced search with additional optional parameters
$response = Scrappa::advancedSearchGmaps('Manila', [
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
        $zoom = $request->input('zoom');
        $response = $this->scrappa->advancedSearchGmaps($query, ['zoom' => $zoom]);
        
        return response()->json($response);
    }
}
```
### 🔍 Autocomplete

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Autocomplete search with only the query parameter
$response = Scrappa::autoCompleteGmaps('Manil');
```

### 🎯 Advanced Search

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Advanced Search (requires both query and zoom parameter)
$response = $response = Scrappa::advancedSearchGmaps('Manila', [
    'zoom' => 5,
]);

// Advanced search with additional optional parameters
$response = Scrappa::advancedSearchGmaps('Manila', [
    'zoom' => 5,          // required
    'lat' => 14.5995,     // optional
    'lon' => 120.9842,    // optional
    'limit' => 10         // optional
]);
```

### ⭐ Google Reviews

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Get Google Reviews (requires placeId and sort)
$response = Scrappa::googleReviewsGmaps('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2', [
    'sort'  => 1,  // required
    'limit' => 1   // optional
]);

// Get Google Reviews with additional optional filters
$response = Scrappa::googleReviewsGmaps('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2',[
    'sort' => 1,                    // required
    'search' => 'Place is good',    // optional
    'limit' => 4,                   // optional
    'page' => 'CAESY0NBR....'       // optional
]);
```


## 📌 Sample API Response

### 🔍 Autocomplete
Example response for `Scrappa::autoCompleteGmaps('Manil')`:

```php
{
    "parameters": {
        "query": "Manil"
    },
    "results": {
        "query": "Manil",
        "suggestions": [
            {
                "type": "place",
                "google_id": "0xd0cda433fa6537d:0x43be781a894fa2b5",
                "place_id": "ChIJfVOmP0PaDA0RtaJPiRp4vkM=",
                "main_text": "Manilva",
                "main_text_highlights": [
                    {
                        "offset": "M",
                        "length": "a"
                    }
                ],
                "latitude": 36.3760794,
                "longitude": -5.2508156999999995,
                "country": "ES"
            },
            {
                "type": "place",
                "google_id": "0x3397ca03571ec38b:0x69d1d5751069c11f",
                "place_id": "ChIJi8MeVwPKlzMRH8FpEHXV0Wk=",
                "main_text": "Manila",
                "main_text_highlights": [
                    {
                        "offset": "M",
                        "length": "a"
                    }
                ],
                "latitude": 14.5995133,
                "longitude": 120.984234,
                "country": "PH"
            },
            {
                "type": "place",
                "google_id": "0x3397c8d26026386d:0x5fed23daac9278d0",
                "place_id": "ChIJbTgmYNLIlzMR0HiSrNoj7V8=",
                "main_text": "Manila",
                "main_text_highlights": [
                    {
                        "offset": "M",
                        "length": "a"
                    }
                ],
                "latitude": 14.609053699999999,
                "longitude": 121.0222565,
                "country": "PH"
            },
            {
                "type": "place",
                "google_id": "0x33963092fa6e5db9:0x9fcd5f23701e7643",
                "place_id": "ChIJuV1u-pIwljMRQ3YecCNfzZ8=",
                "main_text": "Manila Bay",
                "main_text_highlights": [
                    {
                        "offset": "M",
                        "length": "a"
                    }
                ],
                "latitude": 14.5188312,
                "longitude": 120.7579834,
                "country": "PH"
            },
            {
                "type": "place",
                "google_id": "0xd0cdb5de05a74d1:0x8548f04e01058742",
                "place_id": "ChIJ0XRa4F3bDA0RQocFAU7wSIU=",
                "main_text": "Manilva",
                "main_text_highlights": [
                    {
                        "offset": "M",
                        "length": "a"
                    }
                ],
                "latitude": 36.3760684,
                "longitude": -5.2507909,
                "country": "ES"
            }
        ]
    }
}
```


### 🎯 Advanced Search
Example response for:  `Scrappa::autoCompleteGmaps('Manila', ['zoom' => 5, "lat": 14.5995, "lon": 120.9842, "limit": 10])`:

```php
{
    "parameters": {
        "query": "Manila",
        "zoom": 5,
        "lat": 14.5995,
        "lon": 120.9842,
        "limit": 10
    },
    "results": {
        "items": [
            {
                "name": "Manila",
                "price_level": null,
                "price_level_text": null,
                "review_count": 0,
                "rating": null,
                "website": "http://www.manila.gov.ph/",
                "domain": "manila.gov.ph",
                "latitude": 14.5995133,
                "longitude": 120.984234,
                "business_id": "0x3397ca03571ec38b:0x69d1d5751069c11f",
                "subtypes": null,
                "district": null,
                "full_address": "Metro Manila, Philippines",
                "timezone": "Asia/Manila",
                "short_description": null,
                "full_description": null,
                "owner_id": null,
                "owner_name": null,
                "owner_link": null,
                "order_link": null,
                "google_mid": "/m/0195pd",
                "type": null,
                "phone_numbers": [],
                "place_id": "ChIJi8MeVwPKlzMRH8FpEHXV0Wk",
                "photos_sample": [
                    {
                        "photo_id": "CIHM0ogKEICAgID2kK-CYQ",
                        "photo_url": "https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqeaowOjQ4roFM2zty7EePUopeU_hccGjui1gd1NKxGgQd60M0FpgIwgfF7aPG69ILFyNb5tmRdFqcZG9UDFYachNua65q56Jv65_55EYweMi3GI9O_mcMlqjHEuBkb5ZvTkY8D=w114-h86-k-no",
                        "photo_url_large": "https://lh5.googleusercontent.com/p/CIHM0ogKEICAgID2kK-CYQ?w3024-h3024-k-no",
                        "video_thumbnail_url": null,
                        "latitude": 14.589597170096457,
                        "longitude": 120.9747257720516,
                        "type": "photo"
                    }
                ],
                "neighborhood": null,
                "street_address_alt": null,
                "street_address_full": null,
                "city": "Manila",
                "zip_code": null,
                "state": "Metro Manila",
                "country_code": "PH"
            }
        ]
    }
}
```

### ⭐ Google Reviews
Example response for:  `Scrappa::googleReviewsGmaps('0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2',['sort' => 1,'limit' => 1])`:

```php
{
    "parameters": {
        "business_id": "0x3397d32e0a1a024f:0x6d9ee9a72ebf08a2",
        "sort": 1,
        "limit": 1
    },
    "results": {
        "items": [
            {
                "review_id": "ChdDSUhNMG9nS0VKS0ZwZk9iNDlXTnVnRRAB",
                "review_text": [
                    "Being a college student, I really love this Starbucks. I often come here when I dont feel like studying at home. It is just 5 - 10 minutes away, so transportation is affordable and quick. The quiet environment helps me focus, and there's sockets almost everywhere so it is convenient since I always bring my laptop. I highly recommend this spot for students."
                ],
                "rating": 5,
                "timestamp": 1748325690280686,
                "review_link": "https://www.google.com/maps/reviews/data=!4m8!14m7!1m6!2m5!1sChdDSUhNMG9nS0VKS0ZwZk9iNDlXTnVnRRAB!2m1!1s0x0:0x6d9ee9a72ebf08a2!3m1!1s2@1:CIHM0ogKEJKFpfOb49WNugE%7CCgwIuqrVwQYQsNvrhQE%7C?hl=en",
                "review_likes": null,
                "author_id": null,
                "author_link": null,
                "author_name": "JERSEY KEAGAN CAMUNGOL",
                "author_profile_photo": "https://lh3.googleusercontent.com/a-/ALV-UjXtO5Ny5k0OgBr2ljEqFoIEwwr-9iMTIpspjmnQ-l0EhCpI360=s120-c-rp-mo-br100",
                "author_review_count": 1,
                "author_reviews_link": "https://www.google.com/maps/contrib/102970533275200696571/reviews?hl=en",
                "author_local_guide_level": 2,
                "owner_response_timestamp": null,
                "owner_response_text": null,
                "owner_response_language": null,
                "review_language": [
                    "en"
                ],
                "review_form": {
                    "How much did you spend per person?": "₱200–400",
                    "Food": 5,
                    "Service": 5,
                    "Atmosphere": 5,
                    "How would you describe the noise level?": "Quiet, easy to talk",
                    "How long did you wait for a table?": "No wait",
                    "What types of seating were available?": [
                        "Indoor dining area",
                        "Outdoor patio / terrace"
                    ]
                }
            }
        ],
        "nextPage": "CAESY0NBRVFBUnBFUTJwRlNVRlNTWEJEWjI5QlVEZGZURUZVVW5SZlgxOWZSV2hFTlVoRmFrZFdjWGMzVlRnMlprazFUVUZCUVVGQlIyZHVPVEpTTkVOaFR5MXlSa1pqV1VGRFNVRQ=="
    }
}

```


## 🔧 Advanced Usage

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
    ->advancedSearchGmaps('Manila', ['zoom' => 3]);
```

## Error Handling

The package throws `InvalidArgumentException` for:
- Missing required query parameter
- Missing API key

```php
try {
    $response = Scrappa::advancedSearchGmaps('Manila', ['zoom' => 3]);
} catch (InvalidArgumentException $e) {
    // Handle the error
    echo "Error: " . $e->getMessage();
}
```

## Available Parameters

For Autocomplete Google Maps API, you only need query parameter:

- `query` (required): The partial search term to get autocomplete suggestions for (string)


For Advanced Search - Google Maps API, you can use these parameters:

- `query` (required): The search term that will be used by the API (string)
- `zoom` (required): The level of detail displayed on the map. Minimum value is 3 (integer)
- `lat` (optional): Latitude coordinate for the search center (float)
- `lon` (optional): Longitude coordinate for the search center (float)  
- `limit` (optional): Maximum number of results to return (integer)


For Google Review - Google Maps API, you can use these parameters:

- `business_id` (required): The unique Google Business ID (format: 0x...:0x...) (string)
- `sort` (required): Sort order for reviews (1=newest, 2=highest, 3=lowest) (integer)
- `search` (optional): Filter reviews by search term (string)
- `limit` (optional): Maximum number of reviews to return (integer)
- `page` (optional): Page token for pagination (string)  

