<?php

class DBcontroller
{
    public $dbHost = "localhost";
    public $dbUser = "root";
    public $dbPassword = "";
    public $dbName = "artgallery";
    public $connection;

    public function openConnection() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName,
                $this->dbUser,
                $this->dbPassword
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }

    public function closeConnection() {
        $this->connection = null;
    }
}