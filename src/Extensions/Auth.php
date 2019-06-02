<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Illuminate\Contracts\Auth\Factory;
use Twig\Extension\ExtensionInterface;

class Auth extends AbstractExtension implements ExtensionInterface
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new auth extension.
     *
     * @param \Illuminate\Contracts\Auth\Factory
     */
    public function __construct(Factory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('auth', [$this->auth, 'guard']),
            new TwigFunction('auth_check', [$this->auth, 'check']),
            new TwigFunction('auth_guest', [$this->auth, 'guest']),
            new TwigFunction('auth_user', [$this->auth, 'user']),
            new TwigFunction('auth_guard', [$this->auth, 'guard']),
        ];
    }
}
