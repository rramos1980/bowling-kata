<?php
namespace Kata\Tests;

use Kata\Game;

class GameTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->game = $game = new Game;
    }

    /**
     * @test
     */
    public function rolls_zero_pins()
    {
        $this->game->roll(0);
        $this->assertSame($this->game->score(), 0);
    }

    /**
     * @test
     */
    public function rolls_pins()
    {
        $this->game->roll(5);
        $this->assertSame($this->game->score(), 5);
    }

    /**
     * @test
     */
    public function rolls_a_strike()
    {
        $this->game->roll(10);
        $this->game->roll(2);
        $this->game->roll(4);

        $this->assertSame($this->game->score(), 22);
    }

    /**
     * @test
     */
    public function rolls_a_spare()
    {
        $this->game->roll(0);
        $this->game->roll(10);
        $this->game->roll(2);
        $this->game->roll(4);

        $this->assertSame($this->game->score(), 18);
    }

    /**
     * @test
     */
    public function perfect_game()
    {
        $this->rollMany(10, 12);

        $this->assertSame($this->game->score(), 300);
    }

    /**
     * @test
     */
    public function nefast_game()
    {
        $this->rollMany(0, 20);

        $this->assertSame($this->game->score(), 0);
    }

    /**
     * @test
     */
    public function only_spares_game()
    {
        $this->rollMany(5, 21);

        $this->assertSame($this->game->score(), 155);
    }

    /**
     * @test
     */
    public function mixed_game()
    {
        $this->rollMany(5, 10);
        $this->rollMany(0, 4);
        $this->rollMany(10, 5);

        $this->assertSame($this->game->score(), 160);
    }

    /**
     * @test
     */
    public function real_mixed_game()
    {
        $this->rollFrame(8, 2);
        $this->rollFrame(5, 1);
        $this->rollFrame(6, 3);

        $this->assertSame($this->game->score(), 30);
    }


    protected function rollMany($pins, $count)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->game->roll($pins);
        }
    }

    protected function  rollFrame($first, $second)
    {
        $this->game->roll($first);
        $this->game->roll($second);
    }
}
