<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class Dump extends AbstractExtension implements ExtensionInterface
{
    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', 'dump', ['is_safe' => ['html']]),
            new TwigFunction('dd', 'dd', ['is_safe' => ['html']]),
        ];
    }
}
