<?php

namespace Lloople\PHPUnitExtensions\Runners\SlowestTests;

use Exception;
use PDO;

class MySQL extends Channel
{
    /**
     * The connection used to store the results.
     *
     * @var PDO
     */
    protected $connection;

    /**
     * The credentials needed to connect to the database.
     *
     * @var array
     */
    protected $credentials = [
        'database' => 'phpunit_results',
        'table' => 'default',
        'username' => 'root',
        'password' => '',
        'host' => '127.0.0.1'
    ];

    public function __construct( array $credentials = [], ?int $rows = null, ?int $min = 200)
    {
        parent::__construct($rows, $min);

        try {
            $this->credentials = array_merge($this->credentials, $credentials);

            $this->connect();

            $this->createTableIfNotExists();
        } catch (Exception $e) {
            echo "{$this->getClassName()} failed: {$e->getMessage()}" . PHP_EOL;
        }
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

    protected function createTableIfNotExists(): void
    {
        $this->connection->prepare(
            "CREATE TABLE IF NOT EXISTS `{$this->credentials['table']}` (
                `time` float DEFAULT NULL,
                `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                `class` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                PRIMARY KEY (`name`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
        )->execute();
    }

    protected function printResults(): void
    {
        try {
            foreach ($this->testsToPrint() as $test => $time) {
                $this->insert($test, $time);
            }
        } catch (Exception $e) {
            echo "{$this->getClassName()} failed: {$e->getMessage()}" . PHP_EOL;
        }
    }

    protected function insert(string $test, string $time): void
    {
        [$class, $method] = explode('::', $test);

        $this->connection
            ->prepare(
                "INSERT INTO `{$this->credentials['table']}` (time, method, class, name) 
                VALUES(:time, :method, :class, :name) 
                ON DUPLICATE KEY UPDATE time = :time;"
            )
            ->execute([
                'time' => $time,
                'method' => $method,
                'class' => $class,
                'name' => $test,
            ]);
    }
}
