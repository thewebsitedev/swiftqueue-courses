<?php

namespace Swiftqueue\Models;

use PDO;
use PDOException;
use Swiftqueue\Core\Database\AbstractDatabase;

/**
 * Class Database
 * @package Swiftqueue\Models
 */
class Database extends AbstractDatabase
{
    protected $host = "localhost";
    protected $db_name = "swiftqueue";
    protected $username = "root";
    protected $password = "root";
    protected $table_name = "courses";
    protected $conn;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_connection()
    {
        try {
            // Create a connection without specifying the database
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->exec("set names utf8");

            // Check if database exists and create it if not
            $this->create_database();
            // Now connect to the specific database
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Create courses table if not exists
            $this->create_table_courses();
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    protected function create_database()
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Database creation failed: " . $exception->getMessage();
        }
    }

    protected function create_table_courses()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                start_date DATE,
                end_date DATE,
                status VARCHAR(100)
            )";
            $this->conn->exec($sql);
        } catch (PDOException $exception) {
            echo "Table creation failed: " . $exception->getMessage();
        }
    }
}
