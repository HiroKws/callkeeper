<?php

namespace Callkeeper\Interfaces;

interface RateKeeper
{
    /**
     * Constructor.
     *
     * @param int $maxCallCount Maximun execution number per unit time
     * @param int $unitTime     Execution unit time by 1/1000 second units
     */
    public function __construct(int $maxCallCount, int $unitTime);

    /**
     * Limit calling to be lower rate (count/unit time).
     *
     * This is simple logic without using timer.
     */
    public function limit();
}
