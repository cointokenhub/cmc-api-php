<?php

namespace CoinTokenHub\CoinMarketCapApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as GuzzleException;

/**
 * Class CoinMarketCap
 * @package CoinTokenHub\CoinMarketCapApi
 */
class CoinMarketCap {

	/**
	 * @var string
	 */
	const API_URL = 'https://api.coinmarketcap.com/v1/';

	/**
	 * @var string
	 */
	const TICKER_URL = 'ticker';

	/**
	 * @var string
	 */
	const GLOBAL_DATA_URL = 'global';

	/**
	 * @var array
	 */
	public static $validCurrencies = array(
		"AUD", "BRL", "CAD", "CHF", "CLP", "CNY", "CZK", "DKK", "EUR", "GBP", "HKD", "HUF", "IDR", "ILS", "INR", "JPY",
		"KRW", "MXN", "MYR", "NOK", "NZD", "PHP", "PKR", "PLN", "RUB", "SEK", "SGD", "THB", "TRY", "TWD", "ZAR"
	);

	public static $validParameters = array(
		"convert", "start", "limit"
	);

	/**
	 * @var Client
	 */
	public $httpClient;

	/**
	 * CoinMarketCapApi constructor.
	 *
	 * @param Client $httpClient
	 */
	public function __construct(Client $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Method that makes the API call to coinmarketcap.com API
	 * @param $endpoint
	 * @param array $parameters
	 * @return array
	 */
	private function request($endpoint, $parameters = array())
	{
		if (empty($endpoint)) {
			return array();
		}

		$url = self::API_URL . $endpoint;

		if ($parameters) {
			$query = http_build_query($parameters);
			$url = $url . $query;
		}

		try {
			$request = $this->httpClient->request('GET', $url);
			$response = $request->getBody();
			return json_decode($response->getContents(), true);
		} catch (GuzzleException $e) {
			return array();
		}
	}


	/**
	 * @param bool|string $convertToCurrency
	 * @param bool|int $start
	 * @param int $limit
	 * @return array
	 */
	public function ticker($convertToCurrency = false, $start = false, $limit = 100)
	{
		if ($convertToCurrency !== false && !in_array($convertToCurrency, self::$validCurrencies)) {
			return array();
		}

		$parameters = array();

		if ($convertToCurrency) {
			$parameters['convert'] = $convertToCurrency;
		}

		if ($start) {
			$parameters['start'] = $start;
		}

		if ($limit) {
			$parameters['limit'] = $limit;
		}

		return $this->request(self::TICKER_URL, $parameters);
	}

	/**
	 * @param string $coin
	 * @param bool $convertToCurrency
	 * @return array
	 */
	public function currencyTicker($coin, $convertToCurrency = false)
	{
		if ($convertToCurrency !== false && !in_array($convertToCurrency, self::$validCurrencies)) {
			return array();
		}

		$parameters = array();
		if ($convertToCurrency) {
			$parameters['convert'] = $convertToCurrency;
		}

		$ticker = $this->request(self::TICKER_URL . '/' . $coin, $parameters);

		if (!isset($ticker['error']) and isset($ticker[0])) {
			return $ticker[0];
		}

		return array();
	}

	/**
	 * @param bool $convertToCurrency
	 * @return array
	 */
	public function globalData($convertToCurrency = false)
	{
		if ($convertToCurrency !== false && !in_array($convertToCurrency, self::$validCurrencies)) {
			return array();
		}

		$parameters = array();
		if ($convertToCurrency) {
			$parameters['convert'] = $convertToCurrency;
		}

		return $this->request(self::GLOBAL_DATA_URL, $parameters);
	}

}
