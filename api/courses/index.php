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
use Swiftqueue\Controllers\CoursesController;
use Swiftqueue\Controllers\UsersController;

// Instantiate the database connection
$database = new Database();
$db = $database->get_connection();
// Instantiate the controllers
$controller = new CoursesController($db);
// Instantiate the users controller
$user_controller = new UsersController($db);
// Instantiate the request
$request = new Request();
$method = $request->method;
// Get the URL fragments for routing
$url_fragments = $request->url_fragments;

// Basic RESTful routing
$path = ( 'local' === $_ENV['ENV'] ) ? $url_fragments[3] : $url_fragments[2];
if (isset($path) && 'courses' === $path) {
    switch ($method) {
        case 'GET':
            $id = isset( $_GET['id'] ) ? $_GET['id'] : null;
            if ( $id ) {
                $controller->get_course( $id );
            } else {
                $controller->list_courses();
            }
            break;
        case 'POST':
            $controller->create_course();
            break;
        case 'PUT':
            $controller->update_course();
            break;
        case 'DELETE':
            $controller->delete_course();
            break;
        default:
            echo json_encode(['message' => 'Method Not Allowed']);
    }
} elseif(isset($path) && 'users' === $path) {
    switch ($method) {
        case 'POST':
            $user_controller->create_user();
            break;
        default:
            echo json_encode(['message' => 'Method Not Allowed']);
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Allowed']);
}
