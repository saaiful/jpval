<?php namespace Saaiful\Jpval;
use Illuminate\Support\ServiceProvider;
class JpvalServiceProvider extends ServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    
    /**
     * Publish asset
     */
	public function boot() {
		$this->publishes([
		 	 __DIR__.'/../../config/config.php' => config_path('jpval.php'),
		]);
        $this->loadViewsFrom(__DIR__.'/../../views/', 'jpval');
	}


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bindShared('Jpval', function() {
		return new Jpval;
	});
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array("Jpval");
    }
}