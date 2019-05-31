<?php

namespace DinhQuocHan\Twig;

use Illuminate\Support\ServiceProvider;

class TwigServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTwigLoader();
        $this->registerTwigEnvironment();
        $this->registerTwigEngine();
        $this->registerCommands();
    }

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
     * Register twig loader.
     *
     * @return void
     */
    protected function registerTwigLoader()
    {
        $this->app->bind('twig.loader', function ($app) {
            return new TwigLoader($app['view.finder']);
        });
        $this->app->alias('twig.loader', TwigLoader::class);
    }

    /**
     * Register twig environment.
     *
     * @return void
     */
    protected function registerTwigEnvironment()
    {
        $this->app->singleton('twig.environment', function ($app) {
            return tap(new TwigEnvironment($app['twig.loader'], [
                'cache' => $app['config']['view.compiled'],
                'debug' => $app['config']['app.debug'],
            ]), function (TwigEnvironment $environment) use ($app) {
                $environment->addGlobal('app', $app);
            });
        });
    }

    /**
     * Register twig engine.
     *
     * @return void
     */
    public function registerTwigEngine()
    {
        $this->app->bind('twig.engine', function ($app) {
            return new TwigEngine($app['twig.environment']);
        });
        $this->app->alias('twig.engine', TwigEngine::class);
    }

    /**
     * Register view extension.
     *
     * @return void
     */
    protected function registerViewExtension()
    {
        foreach (['twig', 'html.twig', 'css.twig'] as $extension) {
            $this->app['view']->addExtension($extension, 'twig', function () {
                return $this->app['twig.engine'];
            });
        }
    }

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         \Qh\Twig\Console\ViewTwigClearCommand::class,
        //     ]);
        // }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'twig.loader', 'twig.environment', 'twig.engine',
        ];
    }
}
