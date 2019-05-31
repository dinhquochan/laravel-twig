<?php

namespace DinhQuocHan\Twig\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void addGlobal(string $name, $value)
 * @method static void addFilter(\Twig\TwigFilter $filter)
 * @method static void addFunction(\Twig\TwigFunction $function)
 * @method static void addTest(\Twig\TwigTest $test)
 * @method static void addTokenParser(\Twig\TokenParser\TokenParserInterface $parser)
 * @method static void addExtension(\Twig\Extension\ExtensionInterface $extension)
 *
 * @see \DinhQuocHan\Twig\TwigEnvironment
 */
class Twig extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'twig.environment';
    }
}
