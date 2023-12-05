<?php

namespace Swiftqueue\Core\Http;

/**
 * Class Request
 *
 * @package Swiftqueue\Core\Http
 */
class Request {
    private $data;
    public $method;
    public $url;
    public $full_url;
    public $url_fragments;
    public $contentType;

    /**
     * Request constructor.
     */
    public function __construct() {
        // Set the request method, URL, and URL fragments
        $this->method        = $_SERVER['REQUEST_METHOD'];
        $this->url           = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->full_url      = $_SERVER['REQUEST_URI'];
        $this->url_fragments = explode('/', $this->url);
        $this->contentType   = $_SERVER['CONTENT_TYPE'];

        // Set the request data
        if ('POST' === $this->method && 'application/json' !== $this->contentType) {
             // Unsupported Media Type
            http_response_code(415);
            echo json_encode(['error' => 'Invalid content type. Only JSON is accepted.']);
            exit;
        }

        // Set the request data
        $this->data = json_decode(file_get_contents("php://input"), true);

        // Set the request data for GET and DELETE requests
        if ( 'GET' === $this->method || 'DELETE' === $this->method ) {
            $parsed_url = parse_url( $this->full_url );
            if ( !isset( $parsed_url['query'] ) ) {
                return;
            }
            parse_str($parsed_url['query'], $this->data);
        }
    }

    /**
     * Get the request data
     *
     * @param $key string the key to get
     * @param $default string|null the default value
     *
     * @return mixed|null the value
     */
    public function get($key, $default = null) {
        return $this->data[$key] ?? $default;
    }
}
