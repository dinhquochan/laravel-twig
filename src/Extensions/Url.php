<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;

class Url extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('action', 'action', ['is_safe' => ['html']]),
            new TwigFilter('asset', 'asset', ['is_safe' => ['html']]),
            new TwigFilter('route', 'route', ['is_safe' => ['html']]),
            new TwigFilter('secure_asset', 'secure_asset', ['is_safe' => ['html']]),
            new TwigFilter('secure_url', 'secure_url', ['is_safe' => ['html']]),
            new TwigFilter('url', 'url', ['is_safe' => ['html']]),
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
            new TwigFunction('action', 'action', ['is_safe' => ['html']]),
            new TwigFunction('asset', 'asset', ['is_safe' => ['html']]),
            new TwigFunction('route', 'route', ['is_safe' => ['html']]),
            new TwigFunction('secure_asset', 'secure_asset', ['is_safe' => ['html']]),
            new TwigFunction('secure_url', 'secure_url', ['is_safe' => ['html']]),
            new TwigFunction('url', 'url', ['is_safe' => ['html']]),
        ];
    }
}
