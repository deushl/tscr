<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config;

class smallEquation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TrackStreet:smallEquation {csv_list : A comma-separated numeric input sequence}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates and prints the value of: Q = Square root of [(2 * C * D)/H]';

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
        $nC = Config::get('constants.equation.C');
        $cH = Config::get('constants.equation.H');

        if (!is_numeric($nC) || !is_numeric($cH)) {
            $this->error(Config::get('phrases.error.const_not_numeric'));
            return;
        }

        if ($cH == 0) {
            $this->error(Config::get('phrases.error.by_zero'));
            return;
        }

        $cCSVList = $this->argument('csv_list');
        $arCSVList = explode(',', str_replace(' ', '', $cCSVList));
        $arOut = [];

        foreach ($arCSVList as $i => $v) {
            if (!is_numeric($v)) {
                $this->error(Config::get('phrases.error.par_not_numeric') . " $v");
                return;
            }

            if ($v < 0) {
                $this->error(Config::get('phrases.error.negative_value') . " $v");
                return;
            }

            $arOut[]=
                floor(
                    sqrt(
                        (2 * $nC * $v) / $cH
                    )
                );
        }

        $this->info(implode(',', $arOut));
    }
}
