<?php
// File: Controller/DBArtworkManager.php

class DBArtworkManager
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPassword = ''; // Use a secure password & consider config/env variables
    private $dbName = 'artgallery';
    private $mysqliConnection = null;
    private $lastError = null;

    public function __construct()
    {
        // Attempt to open connection on instantiation
        $this->openConnection();
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    private function openConnection()
    {
        // If connection already exists and is live, return true
        if ($this->mysqliConnection && $this->mysqliConnection->ping()) {
            return true;
        }

        // Close any existing (possibly dead) connection
        if ($this->mysqliConnection) {
            $this->mysqliConnection->close();
            $this->mysqliConnection = null;
        }

        $this->mysqliConnection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);

        if ($this->mysqliConnection->connect_error) {
            $this->lastError = "Connection failed: (" . $this->mysqliConnection->connect_errno . ") " . $this->mysqliConnection->connect_error;
            error_log("DBArtworkManager Error: " . $this->lastError);
            $this->mysqliConnection = null; // Ensure it's null on failure
            return false;
        }

        $this->mysqliConnection->set_charset("utf8mb4");
        return true;
    }

    public function getConnection() // Public getter for the connection if needed externally
    {
        if (!$this->mysqliConnection || !$this->mysqliConnection->ping()) {
            if (!$this->openConnection()) {
                return null;
            }
        }
        return $this->mysqliConnection;
    }


    /**
     * Private helper to execute DML statements with explicit types.
     * @param string $query The SQL query with placeholders.
     * @param array $params The parameters to bind.
     * @param string $types The string defining the types for bind_param. MUST be provided if params exist.
     * @return mysqli_stmt|false The statement object on successful execution, false on failure.
     */
    private function _executeStatementInternal($query, $params = [], $types = "")
    {
        $this->lastError = null;
        if (!$this->openConnection()) { // Ensure connection is active
            $this->lastError = "No database connection available.";
            return false;
        }

        if (!empty($params) && empty($types)) {
            $this->lastError = "Parameter types string ('\$types') must be provided when parameters are present.";
            error_log("DBArtworkManager Error: " . $this->lastError . " Query: " . $query);
            return false;
        }
        if (!empty($params) && strlen($types) !== count($params)) {
            $this->lastError = "Number of types (" . strlen($types) . ") does not match number of parameters (" . count($params) . "). Types: '$types'. Query: " . $query;
            error_log("DBArtworkManager Error: " . $this->lastError);
            return false;
        }

        try {
            $stmt = $this->mysqliConnection->prepare($query);
            if ($stmt === false) {
                throw new mysqli_sql_exception("Prepare failed: (" . $this->mysqliConnection->errno . ") " . $this->mysqliConnection->error . " Query: " . $query);
            }

            if (!empty($params)) {
                if (!$stmt->bind_param($types, ...$params)) {
                    throw new mysqli_sql_exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
                }
            }

            if (!$stmt->execute()) {
                throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }
            return $stmt; // Return the statement object

        } catch (mysqli_sql_exception $e) {
            $this->lastError = $e->getMessage();
            error_log("DBArtworkManager _executeStatementInternal Error: " . $this->lastError);
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            return false;
        }
    }

    /**
     * Executes an INSERT query with explicit types.
     * @param string $query The SQL query with placeholders.
     * @param array $params The parameters to bind.
     * @param string $types The string defining the types for bind_param (e.g., "sids").
     * @return mixed The insert ID on success, true if no ID generated but success, false on failure.
     */
    public function insert($query, $params = [], $types = "")
    {
        $stmt = $this->_executeStatementInternal($query, $params, $types);
        if ($stmt) {
            $insertId = $stmt->insert_id;
            $stmt->close();
            return $insertId ?: true; // Return ID if > 0, else true if execution was successful
        }
        return false;
    }

    /**
     * Executes an UPDATE query with explicit types.
     * @param string $query The SQL query with placeholders.
     * @param array $params The parameters to bind.
     * @param string $types The string defining the types for bind_param (e.g., "sidsi").
     * @return bool True on successful execution, false on failure.
     */
    public function update($query, $params = [], $types = "")
    {
        $stmt = $this->_executeStatementInternal($query, $params, $types);
        if ($stmt) {
            // $affected_rows = $stmt->affected_rows; // Can be checked if needed
            $stmt->close();
            return true; // Successful execution
        }
        return false;
    }

    /**
     * Executes a DELETE query with explicit types.
     * @param string $query The SQL query with placeholders.
     * @param array $params The parameters to bind.
     * @param string $types The string defining the types for bind_param (e.g., "ii").
     * @return bool True if rows were affected (>0), false otherwise or on failure.
     */
    public function delete($query, $params = [], $types = "")
    {
        $stmt = $this->_executeStatementInternal($query, $params, $types);
        if ($stmt) {
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            return $affected_rows > 0;
        }
        return false;
    }

    /**
     * Prepares and executes a SELECT query with explicit types.
     * @param string $query The SQL query with placeholders.
     * @param array $params The parameters to bind.
     * @param string $types The string defining the types for bind_param (e.g., "sids").
     * @return array|false An array of associative arrays on success, false on failure.
     */
    public function select($query, $params = [], $types = "")
    {
        $this->lastError = null;
        if (!$this->openConnection()) {
            $this->lastError = "No database connection for select query.";
            return false;
        }
         if (!empty($params) && empty($types)) {
            $this->lastError = "Parameter types string ('\$types') must be provided for select when parameters are present.";
            error_log("DBArtworkManager Error: " . $this->lastError . " Query: " . $query);
            return false;
        }
        if (!empty($params) && strlen($types) !== count($params)) {
            $this->lastError = "Number of types (" . strlen($types) . ") does not match number of parameters (" . count($params) . "). Types: '$types'. Query: " . $query;
            error_log("DBArtworkManager Error: " . $this->lastError);
            return false;
        }

        try {
            $stmt = $this->mysqliConnection->prepare($query);
            if ($stmt === false) {
                throw new mysqli_sql_exception("Prepare failed: (" . $this->mysqliConnection->errno . ") " . $this->mysqliConnection->error . " Query: " . $query);
            }

            if (!empty($params)) {
                if (!$stmt->bind_param($types, ...$params)) {
                     throw new mysqli_sql_exception("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
                }
            }

            if (!$stmt->execute()) {
                throw new mysqli_sql_exception("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result === false) {
                 if ($stmt->error) {
                    throw new mysqli_sql_exception("Getting result set failed: (" . $stmt->errno . ") " . $stmt->error);
                 }
                 $stmt->close();
                 return []; // No error from statement, but no result set (e.g. COUNT query might do this)
            }

            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $data;

        } catch (mysqli_sql_exception $e) {
            $this->lastError = $e->getMessage();
            error_log("DBArtworkManager Select Error: " . $this->lastError);
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            return false;
        }
    }

    public function selectSingle($query, $params = [], $types = "")
    {
        $result = $this->select($query, $params, $types);
        return $result && count($result) > 0 ? $result[0] : null;
    }


    public function getLastError()
    {
        $err = $this->lastError;
        $this->lastError = null; // Clear after retrieval
        if (!$err && $this->mysqliConnection && $this->mysqliConnection->error) {
            // Fallback to connection error if no specific statement error
            return "Connection error: " . $this->mysqliConnection->error;
        }
        return $err;
    }

    public function closeConnection()
    {
        if ($this->mysqliConnection) {
            if (@$this->mysqliConnection->ping()) {
                $this->mysqliConnection->close();
            }
            $this->mysqliConnection = null;
        }
    }

    // Transaction methods (important for multiple operations)
    public function beginTransaction()
    {
        if (!$this->openConnection()) return false;
        return $this->mysqliConnection->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    }

    public function commit()
    {
        if ($this->mysqliConnection && $this->mysqliConnection->ping()) {
            return $this->mysqliConnection->commit();
        }
        return false;
    }

    public function rollback()
    {
        if ($this->mysqliConnection && $this->mysqliConnection->ping()) {
            return $this->mysqliConnection->rollback();
        }
        return false;
    }
}
?>