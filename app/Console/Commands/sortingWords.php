<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\arrayTools;
use Config;

class sortingWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TrackStreet:sortingWords {csv_list : A comma-separated word list}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accepts a comma-separated list of words, sorts them alphabetically, and prints them in a comma-separated list';

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
        $cCSVList = $this->argument('csv_list');
        $arCSVList = explode(',', str_replace(' ', '', $cCSVList));

        if (strlen(str_replace(' ', '', str_replace(',', '', $cCSVList))) == 0) {
            $this->error(Config::get('phrases.error.no_words'));
            return;
        }

        //We could easily use instead: sort($arCSVList, SORT_STRING);
        $arCSVList = arrayTools::quickSortString($arCSVList);

        $this->info(implode(',', $arCSVList));
    }
}
