<?php

namespace DinhQuocHan\Twig\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class TwigViewClearCommand extends Command
{
    /** @var string */
    protected $name = 'view:clear';

    /** @var string */
    protected $description = 'Clear all compiled view files';

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $path = $this->laravel['config']['view.compiled'];

        if (! $path) {
            throw new RuntimeException('View path not found.');
        }

        foreach ($this->files->glob("{$path}/*") as $view) {
            if ($this->files->isDirectory($view)) {
                $this->files->deleteDirectory($view);
                continue;
            }
            if ($this->files->isFile($view)) {
                $this->files->delete($view);
            }
        }

        $this->info('Compiled twig views cleared!');
    }
}
