<?php
namespace CoinTokenHub\CoinMarketCapApi;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CoinMarketCapServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('CoinMarketCap', function () {
			return new CoinMarketCap(new Client());
		});
	}
}