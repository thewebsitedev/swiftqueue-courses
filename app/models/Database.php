<?php

namespace Swiftqueue\Models;

use PDO;
use PDOException;
use Swiftqueue\Core\Database\AbstractDatabase;

/**
 * Class Database
 *
 * @package Swiftqueue\Models
 */
class Database extends AbstractDatabase
{
    protected $table_courses = "courses";
    protected $table_users   = "users";
    protected $conn;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : $this->host;
        $this->db_name = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : $this->db_name;
        $this->username = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : $this->username;
        $this->password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : $this->password;
    }

    /**
     * Get the database connection
     *
     * @return PDO
     */
    public function get_connection()
    {
        try {
            // Create a connection without specifying the database
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->exec("set names utf8");

            // Check if database exists and create it if not
            $this->create_database();
            // Connect to the database
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Create courses table if not exists
            $this->create_table_courses();
            // Create users table if not exists
            $this->create_table_users();
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    /**
     * Create the database if it doesn't exist
     */
    protected function create_database()
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Database creation failed: " . $exception->getMessage();
        }
    }

    /**
     * Create the courses table if it doesn't exist
     */
    protected function create_table_courses()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS " . $this->table_courses . " (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                start_date DATETIME,
                end_date DATETIME,
                status VARCHAR(100)
            )";
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Table creation failed: " . $exception->getMessage();
        }
    }

    /**
     * Create the users table if it doesn't exist
     */
    protected function create_table_users()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS " . $this->table_users . " (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                first_name VARCHAR(50),
                last_name VARCHAR(50),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                role VARCHAR(20)
            )";
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Users table creation failed: " . $exception->getMessage();
        }
    }
}
