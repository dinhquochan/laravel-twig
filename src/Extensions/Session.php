<?php

namespace DinhQuocHan\Twig\Extensions;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Illuminate\Contracts\Session\Session as SessionContract;

class Session extends AbstractExtension implements ExtensionInterface
{
    /**
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * Create a new session extension.
     *
     * @param \Illuminate\Contracts\Session\Session
     */
    public function __construct(SessionContract $session)
    {
        $this->session = $session;
    }

    /**
     * Get functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('session', [$this->session, 'get']),
            new TwigFunction('csrf_token', [$this->session, 'token']),
            new TwigFunction('csrf_field', 'csrf_field', ['is_safe' => ['html']]),
            new TwigFunction('method_field', 'method_field', ['is_safe' => ['html']]),
            new TwigFunction('session_get', [$this->session, 'get']),
            new TwigFunction('session_put', [$this->session, 'put']),
            new TwigFunction('session_pull', [$this->session, 'pull']),
            new TwigFunction('session_has', [$this->session, 'has']),
            new TwigFunction('session_forget', [$this->session, 'forget']),
        ];
    }
}
