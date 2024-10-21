<?php

namespace Indra\RevisorFilament\Commands;

use Illuminate\Console\Command;

class RevisorFilamentCommand extends Command
{
    public $signature = 'laravel-revisor-filament';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
