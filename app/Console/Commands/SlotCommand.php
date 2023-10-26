<?php

namespace App\Console\Commands;

use App\Game;
use Illuminate\Console\Command;

class SlotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To simulate slot machine';


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
        $value = $this->ask('Set your Bet');
        $game = new Game((int)$value);
        $this->info("//////////////////////////////////////////////\n");
        foreach ($game->result() as $key => $value) {
             $this->info($key.': '. json_encode($value));
        }
        $this->info("\n/////////////////////////////////////////////");
    }
}
