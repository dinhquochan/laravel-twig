<?php

namespace DinhQuocHan\Twig;

use Illuminate\View\Factory;
use Illuminate\View\ViewFinderInterface;
use Twig\Loader\LoaderInterface;
use Twig\Loader\SourceContextLoaderInterface;
use Twig\Source;

class TwigLoader implements LoaderInterface, SourceContextLoaderInterface
{
    /** @var \Illuminate\View\Factory */
    protected $view;

    /**
     * TwigLoader constructor.
     *
     * @param  \Illuminate\View\Factory  $view
     */
    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    /**
     * View finder instance.
     *
     * @return \Illuminate\View\ViewFinderInterface
     */
    public function getViewFinder(): ViewFinderInterface
    {
        return $this->view->getFinder();
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param  string $name
     * @return \Twig\Source
     *
     * @throws \Twig\Error\LoaderError
     */
    public function getSourceContext($name)
    {
        if (null === ($path = $this->findTemplate($name)) || false === $path) {
            return new Source('', $name, '');
        }

        return new Source(trim(file_get_contents($path)), $name, $path);
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Twig\Error\LoaderError
     */
    public function getCacheKey($name)
    {
        return '_twig.template.'.hash('sha256', $name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param  string  $name
     * @param  int  $time
     * @return bool
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->findTemplate($name)) < $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param  string  $name
     * @return bool
     */
    public function exists($name)
    {
        if (file_exists($name)) {
            return true;
        }

        return null !== ($path = $this->findTemplate($name)) || false !== $path;
    }

    /**
     * Find template path.
     *
     * @param  string  $name
     * @return string
     */
    protected function findTemplate($name)
    {
        if (file_exists($name)) {
            return $name;
        }

        return $this->getViewFinder()->find($name);
    }
}
