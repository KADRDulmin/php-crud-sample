<?php
/**
 * Database Connection Class
 * 
 * OOP Concepts Used:
 * 1. ENCAPSULATION: Private properties ($host, $username, etc.) are hidden from outside access
 * 2. SINGLETON PATTERN: Ensures only one database connection instance exists
 * 3. ABSTRACTION: Complex database connection logic is hidden behind simple methods
 */

namespace Config;

class Database {
    // ENCAPSULATION: Private properties - data hiding
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "crud";
    private $connection;
    private static $instance = null; // SINGLETON: Static instance variable
    
    /**
     * SINGLETON PATTERN: Private constructor prevents direct instantiation
     * This ensures only one database connection exists throughout the application
     */
    private function __construct() {
        $this->connect();
    }
    
    /**
     * SINGLETON PATTERN: Get single instance of Database class
     * @return Database Single instance of the class
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * ENCAPSULATION: Private method to establish database connection
     * Internal implementation is hidden from outside classes
     */
    private function connect() {
        try {
            $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->connection->connect_error) {
                throw new \Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            // Set charset to prevent SQL injection
            $this->connection->set_charset("utf8mb4");
            
        } catch (\Exception $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }
    
    /**
     * PUBLIC INTERFACE: Get database connection
     * @return mysqli Database connection object
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * RESOURCE MANAGEMENT: Close database connection
     */
    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * SINGLETON PATTERN: Prevent cloning of the instance
     */
    private function __clone() {}
    
    /**
     * SINGLETON PATTERN: Prevent unserialization of the instance
     */
    private function __wakeup() {}
}
?>
