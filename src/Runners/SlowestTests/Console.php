<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Console extends Channel
{

    public function __construct(?int $rows = 5, ?int $min = 200)
    {
        parent::__construct($rows, $min);
    }
    
    protected function printResults(): void
    {
        $tests = $this->testsToPrint();

        if (count($tests) === 0) {
            return;
        }

        echo PHP_EOL . 'Slow tests detected: ' . PHP_EOL;

        foreach ($tests as $test => $time) {
            echo str_pad($time, 5, ' ', STR_PAD_LEFT) . " ms: {$test}" . PHP_EOL;
        }

        echo PHP_EOL;
    }
}