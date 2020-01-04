<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;

abstract class Channel implements AfterTestHook, AfterLastTestHook
{
    protected $tests = [];

    protected $rows;

    public function __construct(int $rows = 5)
    {
        $this->rows = $rows;
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->tests[$test] = $this->timeToMiliseconds($time);
    }

    protected function timeToMiliseconds(float $time)
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
        return array_slice($this->tests, 0, $this->rows, true);
    }

    protected function getClassName(): string
    {
        return get_class($this);
    }
}