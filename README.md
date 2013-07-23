GeoipCountryProvider
====================

Geocoder GeoIP provider that works with the default GeoIP database. This means that you can use this provider to determine the country of a visitor simply by installing `php5-geoip` (or equivalent package).

## Usage

```php
$geocoder = new \Geocoder\Geocoder();
$geocoder->registerProvider(new \GeoipCountryProvider\GeoipCountryProvider());

var_dump($geocoder->geocode('8.8.8.8'));

// Output:
// 
// object(Geocoder\Result\Geocoded)[55]
//   protected 'latitude' => int 0
//   protected 'longitude' => int 0
//   protected 'bounds' => null
//   protected 'streetNumber' => null
//   protected 'streetName' => null
//   protected 'cityDistrict' => null
//   protected 'city' => null
//   protected 'zipcode' => null
//   protected 'county' => null
//   protected 'countyCode' => null
//   protected 'region' => null
//   protected 'regionCode' => null
//   protected 'country' => string 'United States' (length=13)
//   protected 'countryCode' => string 'US' (length=2)
//   protected 'timezone' => null

```
