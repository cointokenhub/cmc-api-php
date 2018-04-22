# CoinMarketCap API Wrapper

[![codecov](https://codecov.io/gh/cointokenhub/cmc-api-php/branch/master/graph/badge.svg)](https://codecov.io/gh/cointokenhub/cmc-api-php) [![Build Status](https://travis-ci.org/cointokenhub/cmc-api-php.svg?branch=master)](https://travis-ci.org/cointokenhub/cmc-api-php)

This php package is a wrapper for the [coinmarketcap.com API](https://coinmarketcap.com/api/). It supports three endpoints:

- The ticker endpoint "/ticker", which returns all crypto currencies, and their vital statistics like price, volume, market cap and percentage changes
- The currency ticker endpoint "/ticker/<coin>", which returns all the data in the previous endpoint, except for only the specified coin.
- The global data endpoint "/global", which returns some stats like the total market cap, active currencies, active markets and so on.


## How to use
