<?php
namespace Kata;

class Game
{
    private $pins_rolled = array();
    private $lastRollInRound = false;
    private $numRounds = 1;

    const PINS_ROLLED_FOR_STRIKE = 10;
    const NUMBER_OF_ROUNDS_IN_GAME = 10;

    public function roll($pins)
    {
        $this->pins_rolled[] = $pins;
    }

    public function score()
    {
        $score = 0;
        $this->lastRollInRound = false;

        foreach ($this->pins_rolled as $key => $pins) {
            $score += $pins + $this->addBonusForRoll($pins, $key);

            if ($this->isLastRollForRound($pins)) {
                $this->moveToNextRound();
            } else {
                $this->moveToNextRollInSameRound();
            }
        }

        return $score;
    }

    protected function addBonusForRoll($pins, $key)
    {
        $bonus = 0;
        if ($this->isStrike($pins) && $this->isNotFinalRounds()) {
            $bonus += $this->getFirstNextRollPins($key);
            $bonus += $this->getSecondNextRollPins($key);
        } elseif ($this->isSpare($pins, $key)) {
            $bonus += $this->getFirstNextRollPins($key);
        }

        return $bonus;
    }

    protected function isStrike($pins)
    {
        return $pins == self::PINS_ROLLED_FOR_STRIKE && !$this->lastRollInRound;
    }

    protected function isNotFinalRounds()
    {
        return $this->numRounds < self::NUMBER_OF_ROUNDS_IN_GAME;
    }

    protected function getFirstNextRollPins($key)
    {
        return $this->getPinsForKey($key + 1);
    }

    protected function getSecondNextRollPins($key)
    {
        return $this->getPinsForKey($key + 2);
    }

    protected function getPinsForKey($key)
    {
        return isset($this->pins_rolled[$key]) ? $this->pins_rolled[$key] : 0;
    }

    protected function isFirstRollInGame($key)
    {
        return $key === 0;
    }

    protected function isSpare($pins, $key)
    {
        return $this->lastRollInRound
               && $pins + $this->getPreviousRollPins($key) == self::PINS_ROLLED_FOR_STRIKE;
    }

    protected function getPreviousRollPins($key)
    {
        return $this->getPinsForKey($key - 1);
    }

    protected function isLastRollForRound($pins)
    {
        return $this->isStrike($pins) || $this->lastRollInRound;
    }

    protected function moveToNextRound()
    {
        $this->lastRollInRound = false;
        $this->numRounds++;
    }

    protected function moveToNextRollInSameRound()
    {
        $this->lastRollInRound = true;
    }
}

