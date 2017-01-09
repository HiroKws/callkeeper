<?php

namespace Callkeeper;

use Callkeeper\Interfaces\RateKeeper;

/**
 * API call limitter implimention for Laravel queue execution.
 *
 * This class intented to be use in single laravel queue worker process.
 * So very simple implimention to keep minimum overhead without using timer.
 */
class Callkeeper implements RateKeeper
{
    /** @var flaot Unix micro time stump for measurement. * */
    protected $baseTime;

    /** @var int Maximun number of execution per an unit time. * */
    protected $maxCall;

    /** @var int Execution unit time by 1/1000 second units. * */
    protected $unitTime;

    /** @var Execution counter for API calling. * */
    protected $apiCounter;

    /**
     * Constructor.
     *
     * @param int $maxCallCount Maximun number of execution per an unit time
     * @param int $unitTime     Execution unit time by 1/1000 second units
     */
    public function __construct(int $maxCallCount, int $unitTime)
    {
        $this->baseTime   = 0.0;
        $this->maxCall    = $maxCallCount;
        $this->unitTime   = $unitTime / 1000.0;
        $this->apiCounter = 0;
    }

    /**
     * Limit calling to be lower rate than maximum execution time
     * in an unit time.
     *
     * This is simple logic implimantion without using timer.
     */
    public function limit()
    {
        $now = microtime(true);

        // When it passed the execution unit time, just reset properties.
        if ($this->baseTime + $this->unitTime < $now) {
            $this->resetProperties($now);

            return;
        }

        // When execution became over than the limit,
        // wait untill the unit time passed.
        if ($this->apiCounter >= $this->maxCall) {
            usleep((int) (($this->baseTime + $this->unitTime - $now) * 1000000));
            $this->resetProperties(microtime(true));

            return;
        }

        ++$this->apiCounter;
    }

    /**
     * Reset this class properties.
     *
     * @param float $now Micro Unix timestump
     */
    private function resetProperties(float $now)
    {
        $this->baseTime   = $now;
        $this->apiCounter = 1;
    }
}
