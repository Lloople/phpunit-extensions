<?php

namespace Lloople\PHPUnitExtensions;

class Time
{
    protected $time;

    public function __construct(float $time)
    {
        $this->time = $time;
    }

    public function __toString(): string
    {
        return round($this->time * 1000, 2);
    }
}