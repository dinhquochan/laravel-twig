<?php

namespace DinhQuocHan\Twig\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ViewClearCommand;
use RuntimeException;

class TwigViewClearCommand extends Command
{
    /** @var string */
    protected $name = 'view:clear';

    /** @var string */
    protected $description = 'Clear all compiled view files';

    /** @var \Illuminate\Foundation\Console\ViewClearCommand */
    protected $viewClearCommand;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    public function __construct(ViewClearCommand $viewClearCommand, Filesystem $files)
    {
        parent::__construct();

        $this->viewClearCommand = $viewClearCommand;

        $this->files = $files;
    }

    public function handle()
    {
        $this->viewClearCommand->handle();

        $path = $this->laravel['config']['view.compiled'];

        if (! $path) {
            throw new RuntimeException('View path not found.');
        }

        foreach ($this->files->glob("{$path}/*") as $view) {
            if ($this->files->isDirectory($view)) {
                $this->files->deleteDirectory($view);
                continue;
            }
        }

        $this->info('Compiled twig views cleared!');
    }
}
