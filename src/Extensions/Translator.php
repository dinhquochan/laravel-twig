<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Translator extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('__', '__', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('trans', 'trans', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('trans_choice', 'trans_choice', ['pre_escape' => 'html', 'is_safe' => ['html']]),
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
            new TwigFunction('__', '__', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFunction('trans', 'trans', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFunction('trans_choice', 'trans_choice', ['pre_escape' => 'html', 'is_safe' => ['html']]),
        ];
    }
}
