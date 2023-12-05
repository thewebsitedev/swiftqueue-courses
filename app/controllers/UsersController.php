<?php

namespace Swiftqueue\Controllers;

use PDOException;
use Swiftqueue\Core\Http\Request;
use Swiftqueue\Models\User;

/**
 * Class UsersController
 *
 * @package Swiftqueue\Controllers
 */
class UsersController
{

    protected $db;
    protected $request;
    protected $user;

    /**
     * UsersController constructor.
     *
     * @param $db PDO database connection
     */
    public function __construct($db)
    {
        $this->db      = $db;
        $this->request = new Request();
        $this->user    = new User($db);
    }

    /**
     * Get a user by email
     *
     * @param $email string user email
     * @param $password string user password
     *
     * @return string json user data
     */
    public function get_user($email,$password)
    {
        $user     = $this->user->get_user($email);
        $password = password_verify($password, $user['password']);

        if (!$password) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials.']);
            exit;
        }

        if( $password ) {
            echo json_encode(['message' => 'login successful']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Something went wrong. Please contact support.']);
        }
    }

    /**
     * Create a user
     *
     * @return string json user data
     */
    public function create_user()
    {
        $email    = $this->request->get('email');
        $password = $this->request->get('password');
        $password = password_hash($password, PASSWORD_DEFAULT);
        $result   = $this->user->add_user($email, $password);

        if ($result) {
            echo json_encode(['message' => 'user added successfully']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to add user.']);
        }
    }
}
