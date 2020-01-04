<?php

namespace Lloople\PHPUnitExtensions\Log;

use Exception;
use PDO;
use PHPUnit\Runner\AfterTestHook;

class SQLite implements AfterTestHook
{
    protected $connection = null;

    protected $credentials = [
        'database' => 'phpunit_results.db',
        'table' => 'default',
    ];

    public function __construct(array $credentials = [])
    {        
        try {
            
            $this->credentials = array_merge($this->credentials, $credentials);

            $this->connect();

            if (! $this->tableExists()) {
                $this->createTable();
            }

        } catch(Exception $e) {
            
            echo "Log: SQLite Extension skipped: {$e->getMessage()}" . PHP_EOL;
            
        }
    }

    public function executeAfterTest(string $test, float $time): void
    {
        if ($this->connection === null) {
            return;
        }

        try {

            $this->insert($test, $time);

        } catch (Exception $e) {

            echo "Log: SQLite Extension skipped: {$e->getMessage()}" . PHP_EOL;

            $this->connection = null;

        }
    }

    protected function insert(string $test, float $time): void
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

    protected function connect(): void
    {
        $this->connection = new PDO("sqlite:{$this->credentials['database']}");
        
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tableExists(): bool
    {
        $query = $this->connection->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=:table;");

        $query->execute(['table' => $this->credentials['table']]);

        return $query->fetch() !== false;
    }

    protected function createTable(): void
    {
        $this->connection->prepare(
            "CREATE TABLE {$this->credentials['table']} (
                `time` float DEFAULT NULL,
                `name` varchar(255) NOT NULL,
                `method` varchar(255) DEFAULT NULL,
                `class` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`name`)
            );"
        )->execute();
    }
}
