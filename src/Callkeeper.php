<?php

namespace Callkeeper;

class Callkeeper
{
    protected $baseTime;

    protected $maxCall;

    protected $unitTime;

    protected $executeCounter;

    /**
     * Constructor.
     *
     * @param int $maxCallCount Maximun execution number per unit time
     * @param int $unitTime     Execution unit time by 1/1000 second units
     */
    public function __construct(int $maxCallCount, int $unitTime)
    {
        $this->baseTime       = 0.0;
        $this->maxCall        = $maxCallCount;
        $this->unitTime       = $unitTime / 1000.0;
        $this->executeCounter = 0;
    }

    /**
     * Limit calling to be lower rate (count/unit time).
     *
     * This is simple logic without using timer.
     */
    public function timeKeep()
    {
        $now = microtime(true);

        if ($this->baseTime + $this->unitTime < $now) {
            $this->resetProperties($now);

            return;
        }

        if ($this->executeCounter >= $this->maxCall) {
            usleep((int) (($this->baseTime + $this->unitTime - $now) * 1000000));
            $this->resetProperties(microtime(true));

            return;
        }
        ++$this->executeCounter;
    }

    /**
     * Reset class properties.
     *
     * @param float $now
     */
    private function resetProperties(float $now)
    {
        $this->baseTime       = $now;
        $this->executeCounter = 1;
    }
}
