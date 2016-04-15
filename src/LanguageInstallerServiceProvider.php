<?php
namespace Ablunier\Laravel\Translation;

use Illuminate\Support\ServiceProvider;
use Ablunier\Laravel\Translation\Services\GithubResourcesRepository;
use Ablunier\Laravel\Translation\Console\Commands\LanguageInstaller;

class LanguageInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/lang-installer.php' => config_path('lang-installer.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lang-installer.php', 'lang-installer');

        $this->app->bind('Ablunier\Laravel\Translation\Services\ResourcesRepository', function ($app) {
            return new GithubResourcesRepository;
        });

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.language.installer', function ($app) {
            $resourcesRepository = $app->make('Ablunier\Laravel\Translation\Services\ResourcesRepository');

            return new LanguageInstaller($resourcesRepository);
        });

        $this->commands('command.language.installer');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.language.installer'
        ];
    }
}
