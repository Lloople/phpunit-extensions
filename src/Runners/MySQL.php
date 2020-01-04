<?php

namespace Lloople\PHPUnitExtensions\Runners;

use Exception;
use Lloople\PHPUnitExtensions\Time;
use PDO;
use PHPUnit\Runner\AfterTestHook;

class MySQL implements AfterTestHook
{
    protected $connection = null;

    protected $credentials = [
        'database' => 'phpunit_results',
        'table' => 'default',
        'username' => 'root',
        'password' => '',
        'host' => '127.0.0.1'
    ];

    public function __construct(array $credentials = [])
    {
        try {
            $this->credentials = array_merge($this->credentials, $credentials);

            $this->connect();

            if (! $this->tableExists()) {
                $this->createTable();
            }
        } catch (Exception $e) {
            echo "MySQL Runner skipped: {$e->getMessage()}" . PHP_EOL;
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
            echo "MySQL Runner skipped: {$e->getMessage()}" . PHP_EOL;

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
                ON DUPLICATE KEY UPDATE time = :time;"
            )
            ->execute([
                'time' => new Time($time),
                'method' => $method,
                'class' => $class,
                'name' => $test,
            ]);
    }

    protected function connect(): void
    {
        $this->connection = new PDO(
            "mysql:dbname={$this->credentials['database']};host={$this->credentials['host']}",
            $this->credentials['username'],
            $this->credentials['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    protected function tableExists(): bool
    {
        $query = $this->connection->prepare(
            "SELECT TABLE_NAME 
            FROM information_schema.tables 
            WHERE table_schema = :database 
            AND table_name = :table 
            LIMIT 1;"
        );

        $query->execute([
            'database' => $this->credentials['database'],
            'table' => $this->credentials['table']
        ]);

        return $query->fetch() !== false;
    }

    protected function createTable(): void
    {
        $this->connection->prepare(
            "CREATE TABLE {$this->credentials['table']} (
                `time` float DEFAULT NULL,
                `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`name`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        )->execute();
    }
}
