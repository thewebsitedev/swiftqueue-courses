<?php

namespace Swiftqueue\Core\Middleware;

/**
 * Class Cors
 * @package Swiftqueue\Core\Middleware
 */
class Cors
{
    public static function setHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}
