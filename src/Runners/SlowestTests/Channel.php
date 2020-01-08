<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;

abstract class Channel implements AfterTestHook, AfterLastTestHook
{
    /**
     * Tests marked as slow.
     *
     * @var array
     */
    protected $tests = [];

    /**
     * The max number of rows to be reported.
     *
     * @var int|null
     */
    protected $rows;

    /**
     * The minimum amount of miliseconds to consider a test slow.
     *
     * @var int|null
     */
    protected $min;

    public function __construct(?int $rows = null, ?int $min = 200)
    {
        $this->rows = $rows;
        $this->min = $min;
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $time = $this->timeToMiliseconds($time);

        if ($time <= $this->min) {
            return;
        }
        
        $this->tests[$test] = $time;
    }

    protected function timeToMiliseconds(float $time): int
    {
        return (int)($time * 1000);
    }

    public function executeAfterLastTest(): void
    {
        $this->sortTestsBySpeed();

        $this->printResults();
    }

    protected function sortTestsBySpeed(): void
    {
        arsort($this->tests);
    }

    abstract protected function printResults(): void;

    protected function testsToPrint(): array
    {
        if ($this->rows === null) {
            return $this->tests;
        }

        return array_slice($this->tests, 0, $this->rows, true);
    }

    protected function getClassName(): string
    {
        return get_class($this);
    }
}