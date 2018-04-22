<?php

use PHPUnit\Framework\TestCase;
use CmcApiPhp\CoinMarketCapApi;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class CoinMarketCapApiTest extends TestCase
{

	private function createHttpClient($statusCode, $body)
	{
		$mock = new MockHandler(
			array(
				new Response($statusCode, array(), $body)
			)
		);
		$handler = HandlerStack::create($mock);
		return new Client(array('handler' => $handler));
	}

	public function testResponseEmptyIfCurrencyInvalidForTicker() {
		$convertToCurrency = 'INVALID';
		$httpClient = new Client();
		$cmcApi = new CoinMarketCapApi($httpClient);
		$this->assertEquals(array(), $cmcApi->ticker($convertToCurrency));
	}

	public function testShouldReturnValidArrayForTicker() {
		$mockResponse = file_get_contents(__DIR__.'/Mock/Ticker/ticker-response-body.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$this->assertEquals(
			json_decode($mockResponse, true),
			$cmcApi->ticker(false, false, 2)
		);
	}

	public function testShouldReturnValidArrayForTickerWithCurrencyLimitAndStart() {
		$mockResponse = file_get_contents( __DIR__ . '/Mock/Ticker/ticker-reponse-aud-limit-5-start-5.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$this->assertEquals(
			json_decode($mockResponse, true),
			$cmcApi->ticker('AUD', 5, 5)
		);
	}

	public function testResponseEmptyIfCurrencyInvalidForCurrencyTicker() {
		$convertToCurrency = 'INVALID';
		$httpClient = new Client();
		$cmcApi = new CoinMarketCapApi($httpClient);
		$this->assertEquals(array(), $cmcApi->currencyTicker($convertToCurrency));
	}

	public function testShouldReturnValidArrayForCurrencyTicker() {
		$mockResponse = file_get_contents( __DIR__ . '/Mock/CurrencyTicker/ticker-maidsafecoin.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$mockResponseArray = json_decode($mockResponse, true);
		$this->assertEquals(
			$mockResponseArray[0],
			$cmcApi->currencyTicker('maidsafecoin', false)
		);
	}

	public function testShouldReturnValidArrayForCurrencyTickerWithCurrency() {
		$mockResponse = file_get_contents( __DIR__ . '/Mock/CurrencyTicker/ticker-maidsafecoin-aud.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$mockResponseArray = json_decode($mockResponse, true);
		$this->assertEquals(
			$mockResponseArray[0],
			$cmcApi->currencyTicker('maidsafecoin', 'AUD')
		);
	}


	public function testShouldReturnErrorResponseForInvalidCurrencyTicker() {
		$mockResponse = '{"error": "id not found"}';
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(404, $mockResponse));
		$this->assertEquals(
			array(),
			$cmcApi->currencyTicker('INVALID123', false)
		);
	}

	public function testResponseEmptyIfCurrencyInvalidForGlobalData() {
		$convertToCurrency = 'INVALID';
		$httpClient = new Client();
		$cmcApi = new CoinMarketCapApi($httpClient);
		$this->assertEquals(array(), $cmcApi->currencyTicker($convertToCurrency));
	}

	public function testShouldReturnValidArrayForGlobalData() {
		$mockResponse = file_get_contents( __DIR__ . '/Mock/GlobalData/globaldata.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$this->assertEquals(
			json_decode($mockResponse, true),
			$cmcApi->globalData()
		);
	}

	public function testShouldReturnValidArrayForGlobalDataWithCurrency() {
		$mockResponse = file_get_contents( __DIR__ . '/Mock/GlobalData/globaldata-aud.txt');
		$cmcApi = new CoinMarketCapApi($this->createHttpClient(200, $mockResponse));
		$this->assertEquals(
			json_decode($mockResponse, true),
			$cmcApi->globalData('AUD')
		);
	}
}