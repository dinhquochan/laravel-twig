<?php

namespace DinhQuocHan\Twig\Tests;

use Mockery as m;
use DinhQuocHan\Twig\Facades\Twig;
use DinhQuocHan\Twig\TwigServiceProvider;

class TwigFacadeTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function twig_facade_must_be_an_instance_of_twig_environment()
    {
        $app = $this->bootApplication();

        $this->assertInstanceOf('\DinhQuocHan\Twig\TwigEnvironment', Twig::getFacadeRoot());
    }

    protected function bootApplication()
    {
        $app = $this->getApplication();

        $app['view.finder'] = m::mock(\Illuminate\View\ViewFinderInterface::class);
        $app['config'] = [
            'app.debug' => true,
            'view.compiled' => __DIR__.'/compiled',
        ];

        $provider = new TwigServiceProvider($app);
        $provider->register();
        $provider->boot();

        Twig::setFacadeApplication($app);

        return $app;
    }
}
