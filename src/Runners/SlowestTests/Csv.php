<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Csv extends Channel
{
    protected $file;
    
    public function __construct(int $rows = 5, string $file = 'phpunit_results.csv')
    {
        $this->rows = $rows;
        $this->file = $file;
    }

    protected function printResults(): void
    {
        $stream = fopen($this->file, 'w');

        fputcsv($stream, ['time', 'method', 'class', 'name']);

        foreach (array_slice($this->tests, 0, $this->rows, true) as $test => $time) {
            [$class, $method] = explode('::', $test);

            fputcsv($stream, [(string)$time, $method, $class, $test]);
        }
    }
}