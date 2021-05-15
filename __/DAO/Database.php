<?php

namespace App\DAO;

use Config;

class Database
{
    private static ?Database $instance = null;

    public function __construct($host, $port, $dbname, $username, $pwd)
    {

        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->pwd = $pwd;

        $this->connect();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database(
                Config::get('dbHost'),
                Config::get('3306'),
                Config::get('dbName'),
                Config::get('dbUsername'),
                Config::get('dbPass')
            );
        }
        return self::$instance;
    }

    public function connect()
    {

        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;port=$this->port";
            $this->conn = new \PDO($dsn, $this->username, $this->pwd);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->logsys .= "Failed to get DB handle: " . $e->getMessage() . "\n";
        }
    }

    public function close()
    {
        $this->conn = null;
    }

    public function getPDO() {
        return $this->conn;
    }

    public function fetchArray($query)
    {
        $stmt = $this->conn->query($query);
        $rows = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
    }
}
