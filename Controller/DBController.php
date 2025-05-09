<?php
class DBController {
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPassword = '';
    private $dbName = 'artgallery';
    private $mysqliConnection = null;

    public function __construct($dbName = 'artgallery') {
        $this->dbName = $dbName;
    }

    public function openConnection() {
        if ($this->mysqliConnection) return true;

        $this->mysqliConnection = new mysqli(
            $this->dbHost, 
            $this->dbUser, 
            $this->dbPassword, 
            $this->dbName
        );

        if ($this->mysqliConnection->connect_error) {
            error_log("MySQLi connection failed: " . $this->mysqliConnection->connect_error);
            return false;
        }
        
        // Set charset to ensure proper encoding
        $this->mysqliConnection->set_charset("utf8mb4");
        return true;
    }

    public function getConnection() {
        if (!$this->mysqliConnection && !$this->openConnection()) {
            error_log("Failed to establish database connection");
            return null;
        }
        return $this->mysqliConnection;
    }

    public function select($query, $params = []) {
        if (!$this->openConnection()) {
            error_log("No database connection for select query");
            return false;
        }

        $stmt = $this->mysqliConnection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed for query: $query - Error: " . $this->mysqliConnection->error);
            return false;
        }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) $types .= 'i';
                elseif (is_double($param)) $types .= 'd';
                else $types .= 's';
            }
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            error_log("Execute failed for query: $query - Error: " . $stmt->error);
            return false;
        }

        $result = $stmt->get_result();
        if (!$result) {
            return true; // For queries that don't return results
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($query, $params = []) {
        if (!$this->openConnection()) {
            error_log("No database connection for execute query");
            return false;
        }

        $stmt = $this->mysqliConnection->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed for query: $query - Error: " . $this->mysqliConnection->error);
            return false;
        }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) $types .= 'i';
                elseif (is_double($param)) $types .= 'd';
                else $types .= 's';
            }
            $stmt->bind_param($types, ...$params);
        }

        $result = $stmt->execute();
        if (!$result) {
            error_log("Execute failed for query: $query - Error: " . $stmt->error);
        }
        return $result;
    }

    public function insert($query, $params = []) {
        if ($this->execute($query, $params)) {
            return $this->mysqliConnection->insert_id;
        }
        return false;
    }

    public function closeConnection() {
        if ($this->mysqliConnection) {
            if (!$this->mysqliConnection->connect_errno) {
                $this->mysqliConnection->close();
            }
            $this->mysqliConnection = null;
        }
    }

    public function getLastError() {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->error;
        }
        return 'No active database connection';
    }

    // Helper method to begin transaction
    public function beginTransaction() {
        if ($this->openConnection()) {
            return $this->mysqliConnection->begin_transaction();
        }
        return false;
    }

    // Helper method to commit transaction
    public function commit() {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->commit();
        }
        return false;
    }

    // Helper method to rollback transaction
    public function rollback() {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->rollback();
        }
        return false;
    }
}