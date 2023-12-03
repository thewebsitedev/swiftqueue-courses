<?php

namespace Swiftqueue\Core\Database;

/**
 * Class AbstractModel
 * @package Swiftqueue\Core\Database
 */
abstract class AbstractDatabase
{
    protected $host;
    protected $db_name;
    protected $username;
    protected $password;
    protected $table_name;
    protected $conn;

    public function __construct()
    {
        $this->conn = null;
    }

    public function get_connection()
    {
    }

    protected function create_database()
    {
    }

    protected function create_table_courses()
    {
    }
}
