<?php

namespace DinhQuocHan\Twig\Tests;

use Mockery as m;
use Illuminate\View\Factory;
use DinhQuocHan\Twig\TwigLoader;
use Illuminate\View\FileViewFinder;
use DinhQuocHan\Twig\TwigEnvironment;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\View\Engines\EngineResolver;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $twigLoader;

    protected $twigEnvironment;

    protected function setUp()
    {
        parent::setUp();

        $this->twigLoader = $this->getTwigLoader();
        $this->twigEnvironment = $this->getTwigEnvironment();
    }

    public function tearDown()
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

        return new TwigLoader($finder);
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
