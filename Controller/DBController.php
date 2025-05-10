<?php
class DBController
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPassword = '';
    private $dbName = 'artgallery';
    private $mysqliConnection = null;

    public function __construct($dbName = 'artgallery')
    {
        $this->dbName = $dbName;
    }

    public function selectSingle($query, $params = [])
    {
        $result = $this->select($query, $params);
        return $result ? $result[0] : null;
    }

    public function openConnection()
    {
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

    public function getConnection()
    {
        if (!$this->mysqliConnection && !$this->openConnection()) {
            error_log("Failed to establish database connection");
            return null;
        }
        return $this->mysqliConnection;
    }

    public function select($query, $params = [])
    {
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
            // This case handles statements that don't return a result set (e.g., DDL)
            // or if get_result() fails for other reasons after a successful execute.
            // For successful DML (INSERT, UPDATE, DELETE) run via execute(), $stmt->affected_rows can be checked.
            // If an INSERT/UPDATE/DELETE was mistakenly passed here, it's better they use execute().
             if ($this->mysqliConnection->error) {
                error_log("Get_result failed for query: $query - Error: " . $this->mysqliConnection->error);
                return false;
            }
            return []; // Return empty array if no results or for non-SELECT successful queries.
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($query, $params = [])
    {
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
        // For SELECT queries, execute() returns true on success but doesn't fetch data.
        // For DML queries, it returns true on success.
        // $stmt->affected_rows could be useful here.
        return $result;
    }

    public function insert($query, $params = [])
    {
        if ($this->execute($query, $params)) {
            return $this->mysqliConnection->insert_id;
        }
        return false;
    }

    public function closeConnection()
    {
        if ($this->mysqliConnection) {
            if (!$this->mysqliConnection->connect_errno) {
                $this->mysqliConnection->close();
            }
            $this->mysqliConnection = null;
        }
    }

    public function getLastError()
    {
        if ($this->mysqliConnection && $this->mysqliConnection->error) {
            return $this->mysqliConnection->error;
        }
        // Check statement error if available (not easily accessible here without passing stmt)
        // Fallback or more generic message
        return $this->mysqliConnection ? 'An error occurred with the database operation.' : 'No active database connection.';
    }
    
    public function getAffectedRows()
    {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->affected_rows;
        }
        return -1; // Or throw an exception, or return false
    }


    // Helper method to begin transaction
    public function beginTransaction()
    {
        if ($this->openConnection()) {
            return $this->mysqliConnection->begin_transaction();
        }
        return false;
    }

    // Helper method to commit transaction
    public function commit()
    {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->commit();
        }
        return false;
    }

    // Helper method to rollback transaction
    public function rollback()
    {
        if ($this->mysqliConnection) {
            return $this->mysqliConnection->rollback();
        }
        return false;
    }
}
?>