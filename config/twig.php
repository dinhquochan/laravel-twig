<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supported view file extensions
    |--------------------------------------------------------------------------
    |
    | Add supported view file extensions. E.g: *.twig, *.html.twig, *.css.twig...
    */
   'file_extensions' => [
        'twig', 'html.twig', 'css.twig',
   ],

    /*
    |--------------------------------------------------------------------------
    | Twig extensions
    |--------------------------------------------------------------------------
    |
    | Enabled twig extensions.
    */

   'extensions' => [
        \DinhQuocHan\Twig\Extensions\Arr::class,
        \DinhQuocHan\Twig\Extensions\Auth::class,
        \DinhQuocHan\Twig\Extensions\Config::class,
        \DinhQuocHan\Twig\Extensions\Dump::class,
        \DinhQuocHan\Twig\Extensions\Gate::class,
        \DinhQuocHan\Twig\Extensions\Path::class,
        \DinhQuocHan\Twig\Extensions\Request::class,
        \DinhQuocHan\Twig\Extensions\Session::class,
        \DinhQuocHan\Twig\Extensions\Str::class,
        \DinhQuocHan\Twig\Extensions\Translator::class,
        \DinhQuocHan\Twig\Extensions\Url::class,
   ],
];
