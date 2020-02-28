<?php

namespace DinhQuocHan\Twig;

use Illuminate\Contracts\View\Engine;

class TwigEngine implements Engine
{
    /*** @var \DinhQuocHan\Twig\TwigEnvironment */
    protected $environment;

    public function __construct(TwigEnvironment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return $this->environment->render($path, $data);
    }
}
