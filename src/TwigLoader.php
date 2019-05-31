<?php

namespace DinhQuocHan\Twig;

use Twig\Source;
use Twig\Loader\LoaderInterface;
use Twig\Loader\ExistsLoaderInterface;
use Illuminate\View\ViewFinderInterface;
use Twig\Loader\SourceContextLoaderInterface;

class TwigLoader implements LoaderInterface, ExistsLoaderInterface, SourceContextLoaderInterface
{
    /** @var \Illuminate\View\ViewFinderInterface */
    protected $viewFinder;

    /**
     * TwigLoader constructor.
     *
     * @param  \Illuminate\View\ViewFinderInterface  $viewFinder
     */
    public function __construct(ViewFinderInterface $viewFinder)
    {
        $this->viewFinder = $viewFinder;
    }

    /**
     * View finder instance.
     *
     * @return \Illuminate\View\ViewFinderInterface
     */
    public function getViewFinder(): ViewFinderInterface
    {
        return $this->viewFinder;
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     *
     * @return Source
     *
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext($name)
    {
        if (null === ($path = $this->getViewFinder()->find($name)) || false === $path) {
            return new Source('', $name, '');
        }

        return new Source(trim(file_get_contents($path)), $name, $path);
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws LoaderError When $name is not found
     */
    public function getCacheKey($name)
    {
        return '_twig.template.'.hash('sha256', $name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int    $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws LoaderError When $name is not found
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->getViewFinder()->find($name)) < $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load
     *
     * @return bool If the template source code is handled by this loader or not
     */
    public function exists($name)
    {
        if (file_exists($name)) {
            return true;
        }

        return null !== ($path = $this->getViewFinder()->find($name)) || false !== $path;
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
