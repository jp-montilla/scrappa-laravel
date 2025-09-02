# Scrappa Laravel Package

A simple and clean Laravel wrapper for the Scrappa API, allowing you to make HTTP requests with parameters to interact with all Scrappa API endpoints. It's a pure API client package with no database dependencies.

---

## ✨ Features

🚀 Simple and clean API client  
🔧 Easy configuration  
📦 No database dependencies  
💡 Laravel Facade support  

### Google Maps API Support
- 🎯 Advanced Search  
- 🔍 Autocomplete  
- 🗺️ Simple Search  
- 🏢 Business Details  
- ⭐ Google Reviews  

---

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

## Using the Facade

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Basic search (only query required)
$response = Scrappa::advancedSearchGmaps('Manila');

// Advanced search with optional parameters
$response = Scrappa::advancedSearchGmaps('Manila', [
    'zoom' => 5,
    'lat' => 14.5995,
    'lon' => 120.9842,
    'limit' => 10
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
---
### 🔍 Autocomplete Google Maps

```php
use JohnPaulMontilla\Scrappa\Facades\Scrappa;

// Autocomplete search with only the query parameter
$response = Scrappa::autoCompleteGmaps('Manila');
```

### 🎯 Advanced Search Google Maps

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

## 📌 Sample API Response

### 🔍 Autocomplete
Example response for `Scrappa::autoCompleteGmaps('Manila')`:

```php
[
    'parameters' => [
        "query" => "Manila"
        "zoom" => 5,
        "lat" => 14.5995,
        "lon" => 120.9842,
        "limit" => 10,
    ],
    'results' => [
        "items" => [
            [
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
                    [
                        "photo_id": "CIHM0ogKEICAgID2kK-CYQ",
                        "photo_url": "https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqeaowOjQ4roFM2zty7EePUopeU_hccGjui1gd1NKxGgQd60M0FpgIwgfF7aPG69ILFyNb5tmRdFqcZG9UDFYachNua65q56Jv65_55EYweMi3GI9O_mcMlqjHEuBkb5ZvTkY8D=w114-h86-k-no",
                        "photo_url_large": "https://lh5.googleusercontent.com/p/CIHM0ogKEICAgID2kK-CYQ?w3024-h3024-k-no",
                        "video_thumbnail_url": null,
                        "latitude": 14.589597170096457,
                        "longitude": 120.9747257720516,
                        "type": "photo"
                    ],
                ],
                "neighborhood": null,
                "street_address_alt": null,
                "street_address_full": null,
                "city": "Manila",
                "zip_code": null,
                "state": "Metro Manila",
                "country_code": "PH"
            ],
        ]
    ]
]
```


### 🎯 Advanced Search
Example response for:  `Scrappa::autoCompleteGmaps('Manila', ['zoom' => 5])`:

```php
[
    'parameters' => [
        'query' => 'Manila'
    ],
    'results' => [
        {
            'query': 'Manila',
            'suggestions': [
                {
                'type': 'place',
                'google_id': '0x3397ca03571ec38b:0x69d1d5751069c11f',
                'place_id': 'ChIJi8MeVwPKlzMRH8FpEHXV0Wk=',
                'main_text': 'Manila',
                'main_text_highlights': [
                    {
                    'offset': 'M',
                    'length': 'a'
                    }
                ],
                'latitude': 14.5995133,
                'longitude': 120.984234,
                'country': 'PH'
                },
                {
                'type': 'place',
                'google_id': '0x3397c8d26026386d:0x5fed23daac9278d0',
                'place_id': 'ChIJbTgmYNLIlzMR0HiSrNoj7V8=',
                'main_text': 'Manila',
                'main_text_highlights': [
                    {
                    'offset': 'M',
                    'length': 'a'
                    }
                ],
                'latitude': 14.609053699999999,
                'longitude': 121.0222565,
                'country': 'PH'
                },
                {
                'type': 'place',
                'google_id': '0x33963092fa6e5db9:0x9fcd5f23701e7643',
                'place_id': 'ChIJuV1u-pIwljMRQ3YecCNfzZ8=',
                'main_text': 'Manila Bay',
                'main_text_highlights': [
                    {
                    'offset': 'M',
                    'length': 'a'
                    }
                ],
                'latitude': 14.5188312,
                'longitude': 120.7579834,
                'country': 'PH'
                },
                {
                'type': 'place',
                'google_id': '0x3397cec5d2bb4d77:0x8a24fa628a114411',
                'place_id': 'ChIJd0270sXOlzMREUQRimL6JIo=',
                'main_text': 'Manila International Airport (MNL)',
                'main_text_highlights': [
                    {
                    'offset': 'M',
                    'length': 'a'
                    }
                ],
                'latitude': 14.512273899999999,
                'longitude': 121.01650799999999,
                'country': 'PH'
                },
                {
                'type': 'place',
                'google_id': '0x3397ca03f50c750d:0x84128778afa3e60c',
                'place_id': 'ChIJDXUM9QPKlzMRDOajr3iHEoQ=',
                'main_text': 'Manila Ocean Park',
                'main_text_highlights': [
                    {
                    'offset': 'M',
                    'length': 'a'
                    }
                ],
                'latitude': 14.5793088,
                'longitude': 120.9724475,
                'country': 'PH'
                }
            ]
        }
    ]
]

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

For Autocomplete, you only need query parameter:

- `query` (required): The partial search term to get autocomplete suggestions for (string)


For Google Maps advanced search, you can use these parameters:

- `query` (required): The search term that will be used by the API (string)
- `zoom` (required): The level of detail displayed on the map. Minimum value is 3 (integer)
- `lat` (optional): Latitude coordinate for the search center (float)
- `lon` (optional): Longitude coordinate for the search center (float)  
- `limit` (optional): Maximum number of results to return (integer)


