# CoinMarketCap API Wrapper

[![codecov](https://codecov.io/gh/cointokenhub/cmc-api-php/branch/master/graph/badge.svg)](https://codecov.io/gh/cointokenhub/cmc-api-php) [![Build Status](https://travis-ci.org/cointokenhub/cmc-api-php.svg?branch=master)](https://travis-ci.org/cointokenhub/cmc-api-php)

This php package is a wrapper for the [coinmarketcap.com API](https://coinmarketcap.com/api/). It supports three endpoints:

- The ticker endpoint "/ticker", which returns all crypto currencies, and their vital statistics like price, volume, market cap and percentage changes
- The currency ticker endpoint "/ticker/<coin>", which returns all the data in the previous endpoint, except for only the specified coin.
- The global data endpoint "/global", which returns some stats like the total market cap, active currencies, active markets and so on.


## Install

    composer require andskur/coinmc

## Usage

```php
<?php

use CoinTokenHub\CoinMarketCapApi\CoinMarketCap;

class SomeController extends Controller
{
    public function index(CoinMarketCap $cmc)
    {

        // Top 100 crypto currencies by market cap
		$cmc->ticker();

		// Get ticker for a specific coin
		$cmc->currencyTicker('rchain');

		// Get global data
		$cmc->globalData();
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
'CoinMarketCap' => CoinTokenHub\CoinMarketCapApi\CoinMarketCapServiceProvider::class,
```
