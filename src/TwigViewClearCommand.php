<?php

namespace DinhQuocHan\Twig;

use RuntimeException;
use Illuminate\Foundation\Console\ViewClearCommand;

class TwigViewClearCommand extends ViewClearCommand
{
    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
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

            $this->files->delete($view);
        }

        $this->info('Compiled views cleared!');
    }
}
