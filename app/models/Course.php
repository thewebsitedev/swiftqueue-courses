<?php

namespace Swiftqueue\Models;

use PDO;

/**
 * Class Course
 * 
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

    /**
     * Course constructor.
     * @param $db PDO database connection
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Basic sanitization
     *
     * @param $input string to sanitize
     * @return string sanitized string
     */
    public function sanitize_text_field($input)
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    /**
     * Get all courses
     * 
     * @param $status string|null the filter status
     * @param $sort string|null the sort order
     * @param $search string|null the search string
     * 
     * @return array courses
     */
    public function get_all_courses($status = null, $sort = 'DESC', $search = null)
    {
        $query = "SELECT * FROM " . $this->table_name;
        if ($status) {
            $status = $this->sanitize_text_field($status);
            $status = explode(',', $status);
            foreach ($status as $key => $value) {
                if ($key === 0) {
                    $query .= " WHERE status = '$value'";
                } else {
                    $query .= " OR status = '$value'";
                }
            }
        }
        if ( $search ) {
            $search = $this->sanitize_text_field($search);
            $search = "%$search%";
        }
        if ($status && $search) {
            $query .= " AND name LIKE :search";
        }
        if (!$status && $search) {
            $query .= " WHERE name LIKE :search";
        }
        if ($sort) {
            $sort = $this->sanitize_text_field($sort);
            $query .= " ORDER BY id $sort";
        }

        $stmt = $this->conn->prepare($query);

        if ($search) {
            $search = $this->sanitize_text_field($search);
            $stmt->bindParam(':search', $search);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single course
     * 
     * @param $id int the course id
     * 
     * @return array course
     */
    public function get_course($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $id = $this->sanitize_text_field($id);
        // Bind values
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a course
     * 
     * @param $name string the course name
     * @param $start_date string the course start date
     * @param $end_date string the course end date
     * @param $status string the course status
     * 
     * @return bool true if successful, false if not
     */
    public function add_course($name, $start_date, $end_date, $status)
    {
        $query = "INSERT INTO " . $this->table_name . " (name, start_date, end_date, status) VALUES (:name, :start_date, :end_date, :status)";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $name = $this->sanitize_text_field($name);
        $start_date = $this->sanitize_text_field($start_date);
        $end_date = $this->sanitize_text_field($end_date);
        $status = $this->sanitize_text_field($status);

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

    /**
     * Delete a course
     * 
     * @param $id int the course id
     * 
     * @return bool true if successful, false if not
     */
    public function delete_course($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $id = $this->sanitize_text_field($id);
        // Bind values
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Update a course
     * 
     * @param $id int the course id
     * @param $name string the course name
     * @param $start_date string the course start date
     * @param $end_date string the course end date
     * @param $status string the course status
     * 
     * @return bool true if successful, false if not
     */
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
            $name = $this->sanitize_text_field($name);
            $stmt->bindParam(':name', $name);
        }
        if ($start_date) {
            $start_date = $this->sanitize_text_field($start_date);
            $stmt->bindParam(':start_date', $start_date);
        }
        if ($end_date) {
            $end_date = $this->sanitize_text_field($end_date);
            $stmt->bindParam(':end_date', $end_date);
        }
        if ($status) {
            $status = $this->sanitize_text_field($status);
            $stmt->bindParam(':status', $status);
        }

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
