<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config;

class findNumbersBy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TrackStreet:findNumbersBy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find numbers which are divisible by X, but are not a multiple of Y';

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
        $nDivisor = Config::get('constants.divisible.by');
        $nNotDivisor = Config::get('constants.divisible.notby');

        $nStart = Config::get('constants.divisible.range.start');
        $nEnd = Config::get('constants.divisible.range.end');

        if ($nDivisor == 0 || $nNotDivisor == 0) {
            $this->error(Config::get('phrases.error.by_zero'));
            return;
        }

        if (!is_numeric($nDivisor) || !is_numeric($nNotDivisor) || !is_numeric($nStart) || !is_numeric($nEnd)) {
            $this->error(Config::get('phrases.error.const_not_numeric'));
            return;
        }

        $nDivisor = abs($nDivisor);
        $nNotDivisor = abs($nNotDivisor);
        $nStart = abs($nStart);
        $nEnd = abs($nEnd);
        $arOut = [];

        $nIterationStart = ceil($nStart / $nDivisor);
        $nIterationEnd = floor($nEnd / $nDivisor);

        for ($nI = $nIterationStart; $nI <= $nIterationEnd; $nI++) {
            $nItem = $nDivisor * $nI;

            if ($nItem % $nNotDivisor != 0) {
                $arOut[] = $nItem;
            }
        }

        $this->info(implode(',', $arOut));
    }
}
