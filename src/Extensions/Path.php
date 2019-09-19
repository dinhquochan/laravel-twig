<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Path extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('app_path', 'app_path', ['is_safe' => ['html']]),
            new TwigFilter('base_path', 'base_path', ['is_safe' => ['html']]),
            new TwigFilter('config_path', 'config_path', ['is_safe' => ['html']]),
            new TwigFilter('database_path', 'database_path', ['is_safe' => ['html']]),
            new TwigFilter('mix', 'mix', ['is_safe' => ['html']]),
            new TwigFilter('public_path', 'public_path', ['is_safe' => ['html']]),
            new TwigFilter('resource_path', 'resource_path', ['is_safe' => ['html']]),
            new TwigFilter('storage_path', 'storage_path', ['is_safe' => ['html']]),
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
            new TwigFunction('app_path', 'app_path', ['is_safe' => ['html']]),
            new TwigFunction('base_path', 'base_path', ['is_safe' => ['html']]),
            new TwigFunction('config_path', 'config_path', ['is_safe' => ['html']]),
            new TwigFunction('database_path', 'database_path', ['is_safe' => ['html']]),
            new TwigFunction('mix', 'mix', ['is_safe' => ['html']]),
            new TwigFunction('public_path', 'public_path', ['is_safe' => ['html']]),
            new TwigFunction('resource_path', 'resource_path', ['is_safe' => ['html']]),
            new TwigFunction('storage_path', 'storage_path', ['is_safe' => ['html']]),
        ];
    }
}
