<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

use PDO;

class SQLite extends MySQL
{

    protected $credentials = [
        'database' => 'phpunit_results.db',
        'table' => 'default',
    ];

    protected function connect(): void
    {
        $this->connection = new PDO("sqlite:{$this->credentials['database']}");
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function createTableIfNotExists(): void
    {
        $this->connection->prepare(
            "CREATE TABLE IF NOT EXISTS `{$this->credentials['table']}` (
                `time` float DEFAULT NULL,
                `name` varchar(255) NOT NULL,
                `method` varchar(255) DEFAULT NULL,
                `class` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`name`)
            );"
        )->execute();
    }

    protected function insert(string $test, string $time): void
    {
        [$class, $method] = explode('::', $test);

        $this->connection
            ->prepare(
                "INSERT INTO `{$this->credentials['table']}` (time, method, class, name) 
                VALUES(:time, :method, :class, :name) 
                ON CONFLICT(name) DO UPDATE SET time = :time;"
            )
            ->execute([
                'time' => $time,
                'method' => $method,
                'class' => $class,
                'name' => $test,
            ]);
    }
}
