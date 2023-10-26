<?php

namespace App;

class Game
{

    /**
     * Game columns number
     *
     * @var integer
     */
    const columns = 5;

    /**
     * Game rows number
     *
     * @var integer
     */
    const rows = 3;
    /**
     * Game amount of Bet in Cents
     *
     * @var integer
     */
    private int $bet_amount = 100;

    /**
     * The array of symbols
     *
     * @var array
     */    
   const symbols = ['8','9', '10', 'J', 'Q', 'K', 'A'];
    
    /**
     * Available paylines
     * @var array
     */
    const paylines = [
        [0, 3, 6, 9, 12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14]
    ];

    /**
     * game win price
     *
     * @var integer
     */
    private int $win = 0;

    /**
     * Array of the matched outcomes
     *
     * @var array
     */
    private array $outcome = [];

    /**
     * Array of Board
     *
     * @var array
     */
    private array $board;

    /**
     * 3 symbols: 20% of the bet.
     * 4 symbols: 200% of the bet.
     * 5 symbols: 1000% of the bet.
     * @var array
     */
    private array $rates = [
        3 => 20,
        4 => 200,
        5 => 1000
    ];

    public function __construct($bet_value)
    {
        $this->bet_amount = $bet_value ? $bet_value : $this->bet_amount;
        $this->board = $this->_getBoard();
        $this->init();
    }

    private function init()
    {
        foreach (static::paylines as $payline) {
            $matched = [];
            $count = 0;

            foreach ($payline as $index) {
                $symbol = $this->board [$index];
                $length = sizeof($matched);
                if ($length > 0 && $symbol !== $matched[$length - 1]) {
                    break;
                }
                $count++;
                $matched[] = $symbol;
            }


            if (in_array($count, array_keys($this->rates))) {
                $this->win += ($this->bet_amount * $this->rates[$count]) / 100;
                $this->outcome[] = [implode(' ', $payline) => $count];
            }
           // dd($matched);
        }
    }

    /**
     * get the random board
     *
     * @return array
     */
    private function _getBoard(): array
    {
        $board = [];
        $symbols = static::symbols;
        $length = static::rows * static::columns;

        for ($i = 0; $i < $length; $i++) {
            array_push($board, $symbols[array_rand(static::symbols)]);
        }

        return $board;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return [
            'board' => $this->board,
            'paylines' => $this->outcome,
            'bet_amount' => $this->bet_amount,
            'total_win' => $this->win
        ];
    }
}
