<?php

namespace DinhQuocHan\Twig\Tests;

class TwigLoaderTest extends TestCase
{
    /** @test */
    public function make_sure_exists_method_is_working_well()
    {
        $this->assertTrue($this->twigLoader->exists('welcome'));
    }

    /** @test */
    public function make_sure_isFresh_method_is_working_well()
    {
        $this->assertTrue($this->twigLoader->isFresh('welcome', INF));
        $this->assertFalse($this->twigLoader->isFresh('welcome', 0));
    }

    /** @test */
    public function make_sure_getCacheKey_method_is_working_well()
    {
        $this->assertEquals($this->twigLoader->getCacheKey('welcome'), '_twig.template.'.hash('sha256', 'welcome'));
    }

    /** @test */
    public function make_sure_getSourceContext_method_is_working_well()
    {
        $this->assertInstanceOf(\Twig\Source::class, $this->twigLoader->getSourceContext('welcome'));
    }
}
