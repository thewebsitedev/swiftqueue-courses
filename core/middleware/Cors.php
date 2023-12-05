<?php

namespace Swiftqueue\Core\Middleware;

/**
 * Class Cors
 *
 * @package Swiftqueue\Core\Middleware
 */
class Cors
{
    /**
     * Set the CORS headers
     * with pre-flight request handling
     */
    public static function setHeaders()
    {
        // Handle pre-flight requests for CORS
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // Return OK status for preflight requests
            header("Access-Control-Allow-Origin: *"); // Adjust in production
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
            header("Access-Control-Allow-Headers: Content-Type, Authorization");
            http_response_code(200);
            exit;
        }
        
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}
