<?php

class DBcontroller
{
    public $dbHost = "localhost";
    public $dbUser = "root";
    public $dbPassword = "";
    public $dbName = "art gallery";
    public $connection;
    
    public function openConnection() {
        $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
    
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    
        return $this->connection;
    }
    
    public function closeConnection() {
        $this->connection = null;
    }
}