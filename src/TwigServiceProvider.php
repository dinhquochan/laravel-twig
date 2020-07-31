<?php

namespace DinhQuocHan\Twig;

use DinhQuocHan\Twig\Console\TwigViewClearCommand;
use Illuminate\Support\ServiceProvider;

class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/twig.php', 'twig');

        $this->registerTwigLoader();
        $this->registerTwigEnvironment();
        $this->registerEngineResolver();
        $this->registerViewExtensions();
        $this->registerCommands();
    }

    public function boot()
    {
        if (! $this->app->runningInConsole() || $this->app instanceof \Laravel\Lumen\Application) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/twig.php' => config_path('twig.php'),
        ]);
    }

    public function provides()
    {
        return [
            'twig.loader',
            'twig.environment',
        ];
    }

    protected function registerTwigLoader()
    {
        $this->app->bind('twig.loader', function ($app) {
            return new TwigLoader($app['view']);
        });
    }

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

    protected function registerEngineResolver()
    {
        $this->app->extend('view.engine.resolver', function ($resolver) {
            $this->registerTwigEngine($resolver);

            return $resolver;
        });
    }

    protected function registerTwigEngine($resolver)
    {
        $resolver->register('twig', function () {
            return new TwigEngine($this->app['twig.environment']);
        });
    }

    protected function registerViewExtensions()
    {
        $extensions = config('twig.file_extensions', ['twig', 'html.twig', 'css.twig']);

        foreach ($extensions as $extension) {
            $this->app['view']->addExtension($extension, 'twig');
        }
    }

    protected function registerCommands()
    {
        $this->app->extend('command.view.clear', function ($abstract, $app) {
            return new TwigViewClearCommand($app['files']);
        });
    }
}
