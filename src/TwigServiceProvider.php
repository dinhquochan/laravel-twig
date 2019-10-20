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
        $this->mergeConfigFrom(__DIR__.'/../config/twig.php', 'twig');

        $this->registerTwigLoader();
        $this->registerTwigEnvironment();
        $this->registerEngineResolver();
        $this->registerViewExtensions();
        $this->registerCommands();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/twig.php' => config_path('twig.php'),
        ]);
    }

    /**
     * Register twig loader.
     *
     * @return void
     */
    protected function registerTwigLoader()
    {
        $this->app->bind('twig.loader', function ($app) {
            return new TwigLoader($app['view']);
        });
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
                $extensions = $app['config']->get('twig.extensions', []);

                foreach ($extensions as $extension) {
                    $environment->addExtension($app->make($extension));
                }
            });
        });
    }

    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    protected function registerEngineResolver()
    {
        $this->app->extend('view.engine.resolver', function ($resolver) {
            $this->registerTwigEngine($resolver);

            return $resolver;
        });
    }

    /**
     * Register twig engine.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    protected function registerTwigEngine($resolver)
    {
        $resolver->register('twig', function () {
            return new TwigEngine($this->app['twig.environment']);
        });
    }

    /**
     * Register view extension.
     *
     * @return void
     */
    protected function registerViewExtensions()
    {
        foreach (['twig', 'html.twig', 'css.twig'] as $extension) {
            $this->app['view']->addExtension($extension, 'twig');
        }
    }

    /**
     * Register commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->extend('command.view.clear', function ($abstract, $app) {
            return new TwigViewClearCommand($abstract, $app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'twig.loader', 'twig.environment',
        ];
    }
}
