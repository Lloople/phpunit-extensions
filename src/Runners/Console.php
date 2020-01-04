<?php

namespace Lloople\PHPUnitExtensions\Runners;

use Lloople\PHPUnitExtensions\Time;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;

class Console implements AfterTestHook, AfterLastTestHook
{
    protected $tests = [];

    protected $rows;

    public function __construct(int $rows = 5)
    {
        $this->rows = $rows;
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->tests[$test] = new Time($time);
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

    protected function printResults(): void
    {
        echo PHP_EOL . "Showing the top {$this->rows} slowest tests:" . PHP_EOL;

        foreach (array_slice($this->tests, 0, $this->rows, true) as $test => $time) {
            echo str_pad($time, 5, ' ', STR_PAD_LEFT) . " ms: {$test}" . PHP_EOL;
        }

        echo PHP_EOL;
    }
}