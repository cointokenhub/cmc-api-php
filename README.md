# CoinMarketCap API Wrapper

[![codecov](https://codecov.io/gh/cointokenhub/cmc-api-php/branch/master/graph/badge.svg)](https://codecov.io/gh/cointokenhub/cmc-api-php) [![Build Status](https://travis-ci.org/cointokenhub/cmc-api-php.svg?branch=master)](https://travis-ci.org/cointokenhub/cmc-api-php)

This php package is a wrapper for the [coinmarketcap.com API](https://coinmarketcap.com/api/). It supports three endpoints:

- The ticker endpoint "/ticker", which returns all crypto currencies, and their vital statistics like price, volume, market cap and percentage changes
- The currency ticker endpoint "/ticker/<coin>", which returns all the data in the previous endpoint, except for only the specified coin.
- The global data endpoint "/global", which returns some stats like the total market cap, active currencies, active markets and so on.


## Install

    composer require cointokenhub/cmc-api-php

## Usage

### In a PHP app:

```php
use GuzzleHttp\Client;
use CoinTokenHub\CoinMarketCapApi\CoinMarketCap;

$httpClient = new Client();
$cmcApi = new CoinMarketCap($httpClient);


$api->ticker('AUD', false, 5);
$api->currencyTicker($coin);
$api->globalData();
```

### In Laravel:
Add a route to `routes/web.php` that looks like below:

```php
Route::get('coin/{coin}', 'CoinController@coin');
Route::get('ticker', 'CoinController@ticker');
Route::get('global_data', 'CoinController@globalData');
```


Controller looks like below:
```php
<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use CoinTokenHub\CoinMarketCapApi\CoinMarketCap;

class CoinController extends Controller
{
	private $httpClient;

	public function __construct(Client $httpClient) {
		$this->httpClient = $httpClient;
	}

    public function coin($coin) {
		$api = new CoinMarketCap($this->httpClient);
		return json_encode($api->currencyTicker($coin));
    }

    public function ticker() {
	    $api = new CoinMarketCap($this->httpClient);
	    return json_encode($api->ticker('AUD', false, 5));
    }

    public function globalData() {
	    $api = new CoinMarketCap($this->httpClient);
	    return json_encode($api->globalData());
    }
}

```

### Configuring for Laravel

#### Laravel 5.5 and higher

You don't need to change or add any config as this package uses [Package Auto Discovery](https://laravel-news.com/package-auto-discovery).

#### Laravel 5.4 and lower

After installing, register the `CoinTokenHub\CoinMarketCapApi\CoinMarketCapServiceProvider` service provider in your `config/app.php` file.

```php
'providers' => [
    // Other service providers...

    CoinTokenHub\CoinMarketCapApi\CoinMarketCapServiceProvider::class,
],
```

Also add the facade to your `aliases` array in the `config/app.php` file in order to easily access this wrapper using the `CoinMarketCap` alias

```php
'CoinMarketCap' => CoinTokenHub\CoinMarketCapApi\CoinMarketCapFacade::class,
```
