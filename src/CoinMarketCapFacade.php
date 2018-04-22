<?php
namespace CoinTokenHub\CoinMarketCapApi;
use Illuminate\Support\Facades\Facade;

class CoinMarketCapFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'CoinMarketCap';
	}
}