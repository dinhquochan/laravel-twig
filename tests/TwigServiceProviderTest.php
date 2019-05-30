<?php

namespace DinhQuocHan\LaravelTwig\Tests;

use DinhQuocHan\LaravelTwig\TwigServiceProvider;

class TwigServiceProviderTest extends TestCase
{
    /** @test */
    public function make_sure_registered_providers_is_bounded()
    {
        $app = $this->getApplication();
        $provider = new TwigServiceProvider($app);

        foreach ($provider->provides() as $binding) {
            $this->assertFalse($app->bound($binding));
        }

        $provider->register();
        $provider->boot();

        foreach ($provider->provides() as $binding) {
            $this->assertTrue($app->bound($binding));
        }
    }
}
