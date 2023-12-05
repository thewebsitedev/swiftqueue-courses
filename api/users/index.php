<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Swiftqueue\Core\Middleware\Cors;

// Set the CORS headers for security
Cors::setHeaders();

// Load the environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->safeLoad();

use Swiftqueue\Models\Database;
use Swiftqueue\Core\Http\Request;
use Swiftqueue\Controllers\UsersController;

// Instantiate the database connection
$database = new Database();
$db = $database->get_connection();
// Instantiate the users controller
$user_controller = new UsersController($db);
// Instantiate the request
$request = new Request();
$method = $request->method;
// Get the URL fragments for routing
$url_fragments = $request->url_fragments;

// Basic RESTful routing
if(isset($url_fragments[3]) && 'users' === $url_fragments[3]) {
    switch ($method) {
        case 'POST':
            $register = $request->get('register');
            $login = $request->get('login');
            $email = $request->get('email');
            $password = $request->get('password');
            if ($register) {
                $user_controller->create_user();
            }
            if ($login) {
                $user_controller->get_user($email,$password);
            }
            break;
        default:
            echo json_encode(['message' => 'Method Not Allowed']);
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Allowed']);
}
