<?php

namespace DinhQuocHan\Twig;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ViewClearCommand;
use RuntimeException;

class TwigViewClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'view:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all compiled view files';

    /**
     * Clear view command instance.
     *
     * @var \Illuminate\Foundation\Console\ViewClearCommand
     */
    protected $viewClearCommand;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Twig clear view command construct.
     *
     * @param  \Illuminate\Foundation\Console\ViewClearCommand  $viewClearCommand
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(ViewClearCommand $viewClearCommand, Filesystem $files)
    {
        parent::__construct();

        $this->viewClearCommand = $viewClearCommand;

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
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
