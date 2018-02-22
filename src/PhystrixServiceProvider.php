<?php 
namespace Eclipsesk\Phystrix;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class PhystrixServiceProvider extends LaravelServiceProvider {

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
    public function boot() {

        $this->handleConfigs();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $config = new \Zend\Config\Config(config("phystrix"));

        $stateStorage = new \App\Classes\ApcuStateStorage();
        $circuitBreakerFactory = new \Odesk\Phystrix\CircuitBreakerFactory($stateStorage);
        $commandMetricsFactory = new \Odesk\Phystrix\CommandMetricsFactory($stateStorage);

        $phystrix = new \Odesk\Phystrix\CommandFactory(
            $config, new \Zend\Di\ServiceLocator(), $circuitBreakerFactory, $commandMetricsFactory,
            new \Odesk\Phystrix\RequestCache(), new \Odesk\Phystrix\RequestLog()
        );

        $this->app->instance('Eclipsesk\Phystrix\Phystrix', $phystrix);

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return [];
    }

    private function handleConfigs() {

        $configPath = __DIR__ . '/../config/phystrix.php';

        $this->publishes([$configPath => config_path('phystrix.php')]);

        $this->mergeConfigFrom($configPath, 'phystrix');
    }
}
