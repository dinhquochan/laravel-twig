<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Illuminate\Contracts\Config\Repository;

class Config extends AbstractExtension implements ExtensionInterface
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create a new config extension.
     *
     * @param \Illuminate\Contracts\Config\Repository
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('config', [$this->config, 'get']),
            new TwigFunction('config_get', [$this->config, 'get']),
            new TwigFunction('config_has', [$this->config, 'has']),
        ];
    }
}
