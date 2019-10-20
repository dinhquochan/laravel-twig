<?php

namespace DinhQuocHan\Twig;

use DinhQuocHan\Twig\Console\LumenTwigViewClearCommand;
use DinhQuocHan\Twig\Console\TwigViewClearCommand;
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
        if (! $this->app->runningInConsole() || $this->app instanceof \Laravel\Lumen\Application) {
            return;
        }

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

                // Because, lumen is not support illuminate/session.
                // If you want to use Session, must use Laravel instead.
                $lumenIgnoreExtensions = [
                    \DinhQuocHan\Twig\Extensions\Session::class,
                ];

                foreach ($extensions as $extension) {
                    if ($app instanceof \Laravel\Lumen\Application && in_array($extension, $lumenIgnoreExtensions)) {
                        continue;
                    }

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
        if (! $this->app->has('command.view.clear')) {
            $this->commands(LumenTwigViewClearCommand::class);
            return;
        }

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
