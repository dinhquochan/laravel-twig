<?php

namespace DinhQuocHan\Twig\Extensions;

use Illuminate\Support\Str;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class Arr extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('array_*', function ($name, ...$arguments) {
                return call_user_func_array([\Illuminate\Support\Arr::class, Str::camel($name)], $arguments);
            }),
            new TwigFunction('data_fill', 'data_fill'),
            new TwigFunction('data_get', 'data_get'),
            new TwigFunction('data_set', 'data_set'),
            new TwigFunction('head', 'head'),
            new TwigFunction('last', 'last'),
        ];
    }
}
