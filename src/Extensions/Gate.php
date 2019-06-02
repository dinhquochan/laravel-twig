<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class Gate extends AbstractExtension implements ExtensionInterface
{
    /**
     * @var \Illuminate\Contracts\Auth\Access\Gate
     */
    protected $gate;

    /**
     * Create a new gate extension.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate
     */
    public function __construct(GateContract $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('can', [$this->gate, 'check']),
            new TwigFunction('cant', [$this->gate, 'denies']),
            new TwigFunction('cannot', [$this->gate, 'denies']),
            new TwigFunction('allows', [$this->gate, 'allows']),
            new TwigFunction('denies', [$this->gate, 'denies']),
        ];
    }
}
