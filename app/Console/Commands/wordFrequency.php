<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\arrayTools;
use Config;

class wordFrequency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TrackStreet:wordFrequency {phrase : A phrase on which to compute word frequency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Computes the frequency of the words from a given input';

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
        $cPhrase = $this->argument('phrase');

        if (strlen(str_replace(' ', '', $cPhrase)) == 0) {
            $this->error(Config::get('phrases.error.no_words'));
            return;
        }

        $cPhrase = trim(preg_replace('/\s{2,}/', ' ', $cPhrase));
        $arWords = explode(' ', $cPhrase);

        $arHash = [];

        foreach ($arWords as $i => $v) {
            $arHash[$v] = isset($arHash[$v]) ? ++$arHash[$v] : 1;
        }
        
        $arOut = [];

        foreach ($arHash as $i => $v) {
            $arOut[]= "$i:$v";
        }

        //We could easily use instead: ksort($arHash, SORT_STRING);
        $arOut = arrayTools::quickSortString($arOut);

        $this->info(implode(PHP_EOL, $arOut));
    }
}
