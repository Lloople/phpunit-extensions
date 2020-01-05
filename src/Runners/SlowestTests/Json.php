<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Json extends Channel
{
    protected $file;
    
    public function __construct(int $rows = 5, string $file = 'phpunit_results.json')
    {
        $this->rows = $rows;
        $this->file = $file;
    }

    protected function printResults(): void
    {
        $stream = fopen($this->file, 'w');

        $json = [];

        foreach ($this->testsToPrint() as $test => $time) {
            [$class, $method] = explode('::', $test);

            $json[] = [
                'time' => $time,
                'method' => $method,
                'class' => $class,
                'name' => $test
            ];
        }

        fwrite($stream, json_encode($json, JSON_PRETTY_PRINT));

        fclose($stream);
    }
}