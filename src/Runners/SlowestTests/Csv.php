<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Csv extends Channel
{
    protected $file;
    
    public function __construct(?int $rows = null, string $file = 'phpunit_results.csv')
    {
        parent::__construct($rows);

        $this->file = $file;
    }

    protected function printResults(): void
    {
        $stream = fopen($this->file, 'w');

        fputcsv($stream, ['time', 'method', 'class', 'name']);

        foreach ($this->testsToPrint() as $test => $time) {
            [$class, $method] = explode('::', $test);

            fputcsv($stream, [$time, $method, $class, $test]);
        }

        fclose($stream);
    }
}