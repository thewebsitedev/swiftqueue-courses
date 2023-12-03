<?php

namespace Swiftqueue\Core\Http;

/**
 * Class Request
 * @package Swiftqueue\Core\Http
 */
class Request {
    private $data;
    public $method;
    public $url;
    public $full_url;
    public $url_fragments;
    public $contentType;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->full_url = $_SERVER['REQUEST_URI'];
        $this->url_fragments = explode('/', $this->url);
        $this->contentType = $_SERVER['CONTENT_TYPE'];

        if ('POST' === $this->method && 'application/json' !== $this->contentType) {
            http_response_code(415); // Unsupported Media Type
            echo json_encode(['error' => 'Invalid content type. Only JSON is accepted.']);
            exit;
        }

        $this->data = json_decode(file_get_contents("php://input"), true);

        if ('DELETE' === $this->method ) {
            $parsed_url = parse_url( $this->full_url );
            parse_str($parsed_url['query'], $this->data);
        }

        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     http_response_code(400); // Bad Request
        //     echo json_encode(['error' => 'Invalid JSON format.']);
        //     exit;
        // }
    }

    public function get($key, $default = null) {
        return $this->data[$key] ?? $default;
    }
    
}
