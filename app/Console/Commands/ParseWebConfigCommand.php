<?php

namespace App\Console\Commands;

use App\Services\ParseWebConfigService;
use Illuminate\Console\Command;

class ParseWebConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iis:parse {--source=} {--dest=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $source = $this->option('source');
        $dest = $this->option('dest ');

        $parser = new ParseWebConfigService();

        $parser->run($source, $dest)->parse();
    }
}
