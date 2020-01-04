<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Console extends Channel
{
    protected function printResults(): void
    {
        echo PHP_EOL . "Showing the top {$this->rows} slowest tests:" . PHP_EOL;

        foreach ($this->testsToPrint() as $test => $time) {
            echo str_pad($time, 5, ' ', STR_PAD_LEFT) . " ms: {$test}" . PHP_EOL;
        }

        echo PHP_EOL;
    }
}