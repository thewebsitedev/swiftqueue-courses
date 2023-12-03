<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Swiftqueue\Core\Middleware\Cors;

Cors::setHeaders();

use Swiftqueue\Models\Database;
use Swiftqueue\Core\Http\Request;
use Swiftqueue\Controllers\CoursesController;

$database = new Database();
$db = $database->get_connection();
$controller = new CoursesController($db);

$request = new Request();
$method = $request->method;
$url_fragments = $request->url_fragments;

// Basic RESTful routing
if ('courses' === $url_fragments[3]) {
    switch ($method) {
        case 'GET':
            $controller->list_courses();
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
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Allowed']);
}
