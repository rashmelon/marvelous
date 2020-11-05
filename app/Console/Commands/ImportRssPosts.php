<?php

namespace App\Console\Commands;

use App\Jobs\ImportPostsFromSource;
use App\Models\Brand;
use App\Models\Source;
use Illuminate\Console\Command;

class ImportRssPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:posts:rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from specified rss sources ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Brand::all()->flatMap
            ->sources
            ->where('type', Source::XML_FEED)
            ->each(function (Source $source) {
                ImportPostsFromSource::dispatch($source);
            });

        return 0;
    }
}
