<?php

namespace Elfeffe\Medialibrary\Commands;

use Illuminate\Console\Command;

class MedialibraryCommand extends Command
{
    public $signature = 'medialibrary';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
