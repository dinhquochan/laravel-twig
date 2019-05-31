<?php

namespace DinhQuocHan\Twig\Tests;

use DinhQuocHan\Twig\TwigEngine;

class TwigEngineTest extends TestCase
{
    /** @test */
    public function make_sure_get_method_is_working_well()
    {
        $this->assertEquals($this->getTwigEngine()->get('welcome'), 'Hello World!');
    }

    /** @test */
    public function make_sure_get_method_is_working_well_with_namespace()
    {
        $this->assertEquals($this->getTwigEngine()->get('namespace::welcome'), 'Hello World!');
    }

    protected function getTwigEngine()
    {
        return new TwigEngine($this->twigEnvironment);
    }
}
