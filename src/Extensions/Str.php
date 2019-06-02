<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;

class Str extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('__', '__'),
            new TwigFilter('class_basename', 'class_basename'),
            new TwigFilter('preg_replace_array', 'preg_replace_array'),
            new TwigFilter('str_*', function ($name, $arguments) {
                return call_user_func_array([Str::class, Str::camel($name)], $arguments);
            }),
            new TwigFilter('snake_case', [Str::class, 'snake']),
            new TwigFilter('camel_case', [Str::class, 'camel']),
            new TwigFilter('studly_case', [Str::class, 'studly']),
            new TwigFilter('kebab_case', [Str::class, 'kebab']),
        ];
    }

    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('__', '__'),
            new TwigFunction('str_*', function ($name, $arguments) {
                return call_user_func_array([Str::class, Str::camel($name)], $arguments);
            }),
            new TwigFunction('snake_case', [Str::class, 'snake']),
            new TwigFunction('camel_case', [Str::class, 'camel']),
            new TwigFunction('studly_case', [Str::class, 'studly']),
            new TwigFunction('kebab_case', [Str::class, 'kebab']),
        ];
    }
}
