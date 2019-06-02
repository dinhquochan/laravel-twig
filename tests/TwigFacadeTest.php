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

        $app['auth'] = m::mock('Illuminate\Contracts\Auth\Factory');

        $app['view.finder'] = m::mock('Illuminate\View\ViewFinderInterface');

        $app['config'] = new \Illuminate\Config\Repository([
            'app.debug' => true,
            'view.compiled' => __DIR__.'/compiled',
        ]);

        $app['request'] = m::mock('Illuminate\Http\Request');

        $app['session'] = m::mock('Illuminate\Session\SessionManager');

        $app['session.store'] = m::mock('Illuminate\Session\Store');

        $app['Illuminate\Contracts\Auth\Access\Gate'] = new \Illuminate\Auth\Access\Gate($app, function () {
            //
        });

        $provider = new TwigServiceProvider($app);
        $provider->register();
        $provider->boot();

        Twig::setFacadeApplication($app);

        return $app;
    }
}
