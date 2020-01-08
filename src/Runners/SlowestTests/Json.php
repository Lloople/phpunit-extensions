<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

class Json extends Channel
{
    /**
     * The name of the file to store the output.
     *
     * @var string
     */
    protected $file;
    
    public function __construct(string $file = 'phpunit_results.json', ?int $rows = null, ?int $min = 200)
    {
        parent::__construct($rows, $min);

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