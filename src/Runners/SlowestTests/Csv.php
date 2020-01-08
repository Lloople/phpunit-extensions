<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Csv extends Channel
{
    /**
     * The name of the file to store the output.
     *
     * @var string
     */
    protected $file;
    
    public function __construct(string $file = 'phpunit_results.csv', ?int $rows = null, ?int $min = 200)
    {
        parent::__construct($rows, $min);

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