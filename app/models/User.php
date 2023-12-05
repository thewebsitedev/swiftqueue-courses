<?php

namespace Swiftqueue\Models;

use PDO;

/**
 * Class User
 *
 * @package Swiftqueue\Models
 */
class User
{
    protected $conn;
    protected $table_name = 'users';

    /**
     * User constructor.
     *
     * @param $db PDO database connection
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Basic email sanitization
     *
     * @param $email email to sanitize
     *
     * @return string sanitized email
     */
    public function sanitize_email($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
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
     * Get user by email
     * 
     * @param $email string the email
     * 
     * @return array user
     */
    public function get_user($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $email = $this->sanitize_email($email);
        // Bind values
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add user
     * 
     * @param $email string user email
     * @param $password string user password
     * 
     * @return bool true if successful, false otherwise
     */
    public function add_user($email,$password)
    {
        $query = "INSERT INTO " . $this->table_name . " (email, password) VALUES (:email, :password)";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $email = $this->sanitize_email($email);
        $password = $this->sanitize_text_field($password);
        // Bind values
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
