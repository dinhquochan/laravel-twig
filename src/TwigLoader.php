<?php

namespace DinhQuocHan\Twig;

use Illuminate\View\Factory;
use Illuminate\View\ViewFinderInterface;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class TwigLoader implements LoaderInterface
{
    /** @var \Illuminate\View\Factory */
    protected $view;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function getViewFinder(): ViewFinderInterface
    {
        return $this->view->getFinder();
    }

    public function getSourceContext(string $name): Source
    {
        if (null === ($path = $this->findTemplate($name)) || false === $path) {
            return new Source('', $name, '');
        }

        return new Source(trim(file_get_contents($path)), $name, $path);
    }

    public function getCacheKey(string $name): string
    {
        return '_twig.template.'.hash('sha256', $name);
    }

    public function isFresh(string $name, int $time): bool
    {
        return filemtime($this->findTemplate($name)) < $time;
    }

    public function exists(string $name): bool
    {
        if (file_exists($name)) {
            return true;
        }

        return null !== ($path = $this->findTemplate($name)) || false !== $path;
    }

    protected function findTemplate(string $name): string
    {
        if (file_exists($name)) {
            return $name;
        }

        return $this->getViewFinder()->find($name);
    }
}
