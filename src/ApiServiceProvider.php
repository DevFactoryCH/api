<?php namespace Devfactory\Api;

use Illuminate\Support\ServiceProvider;

use Devfactory\Api\Api;
use Devfactory\Api\Provider\RequestProvider;

class ApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('devfactory/api', 'api', __DIR__);

    require __DIR__ . '/ResponseMacro.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
    $this->app['api'] = $this->app->share(function($app) {
      return new Api(new RequestProvider());
    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('api');
	}

}
