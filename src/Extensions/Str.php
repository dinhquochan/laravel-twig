<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Illuminate\Support\Str as IlluminateStr;

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
            new TwigFilter('str_*', function ($name, ...$arguments) {
                return call_user_func_array([IlluminateStr::class, IlluminateStr::camel($name)], $arguments);
            }),
            new TwigFilter('snake_case', [IlluminateStr::class, 'snake']),
            new TwigFilter('camel_case', [IlluminateStr::class, 'camel']),
            new TwigFilter('studly_case', [IlluminateStr::class, 'studly']),
            new TwigFilter('kebab_case', [IlluminateStr::class, 'kebab']),
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
            new TwigFunction('str_*', function ($name, ...$arguments) {
                return call_user_func_array([IlluminateStr::class, IlluminateStr::camel($name)], $arguments);
            }),
            new TwigFunction('snake_case', [IlluminateStr::class, 'snake']),
            new TwigFunction('camel_case', [IlluminateStr::class, 'camel']),
            new TwigFunction('studly_case', [IlluminateStr::class, 'studly']),
            new TwigFunction('kebab_case', [IlluminateStr::class, 'kebab']),
        ];
    }
}
