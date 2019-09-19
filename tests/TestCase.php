<?php

namespace DinhQuocHan\Twig\Tests;

use DinhQuocHan\Twig\TwigEnvironment;
use DinhQuocHan\Twig\TwigLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Mockery as m;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $twigLoader;

    protected $twigEnvironment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twigLoader = $this->getTwigLoader();
        $this->twigEnvironment = $this->getTwigEnvironment();
    }

    public function tearDown(): void
    {
        m::close();
    }

    protected function getTwigEnvironment()
    {
        return new TwigEnvironment($this->twigLoader, [
            'cache' => __DIR__.'/compiled',
            'debug' => true,
        ]);
    }

    protected function getTwigLoader()
    {
        $filesystem = new Filesystem();

        $finder = new FileViewFinder($filesystem, [__DIR__.'/views']);
        $finder->addExtension('twig');
        $finder->addNamespace('namespace', __DIR__.'/views');

        $view = m::mock(Factory::class);
        $view->shouldReceive('getFinder')->andReturn($finder);

        return new TwigLoader($view);
    }

    protected function getApplication(array $customConfig = [])
    {
        return tap(new Application, function ($app) {
            /*
             * @var \Illuminate\Foundation\Application $app
             */
            $app->instance('path', __DIR__);

            // Default
            $app['env'] = 'testing';

            // Filesystem
            $files = m::mock('Illuminate\Filesystem\Filesystem');
            $app['files'] = $files;

            // View
            $finder = m::mock('Illuminate\View\ViewFinderInterface');
            $finder->shouldReceive('addExtension');

            $app['view'] = new Factory(
                new EngineResolver,
                $finder,
                m::mock('Illuminate\Events\Dispatcher')
            );
        });
    }
}
