<?php

namespace Swiftqueue\Models;

use PDO;

/**
 * Class Course
 * @package Swiftqueue\Models
 */
class Course
{
    protected $conn;
    protected $table_name = 'courses';

    public $id;
    public $name;
    public $start_date;
    public $end_date;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_all_courses()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_course($name, $start_date, $end_date, $status)
    {
        $query = "INSERT INTO " . $this->table_name . " (name, start_date, end_date, status) VALUES (:name, :start_date, :end_date, :status)";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete_course($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update_course($id, $name, $start_date, $end_date, $status)
    {
        $query = "UPDATE " . $this->table_name . " SET ";
        if ($name) {
            $query .= "name = :name, ";
        }
        if ($start_date) {
            $query .= "start_date = :start_date, ";
        }
        if ($end_date) {
            $query .= "end_date = :end_date, ";
        }
        if ($status) {
            $query .= "status = :status, ";
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $id);
        if ($name) {
            $stmt->bindParam(':name', $name);
        }
        if ($start_date) {
            $stmt->bindParam(':start_date', $start_date);
        }
        if ($end_date) {
            $stmt->bindParam(':end_date', $end_date);
        }
        if ($status) {
            $stmt->bindParam(':status', $status);
        }

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
