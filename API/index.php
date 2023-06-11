<?php

// Define base URL
$base_url = 'https://api.mpt-journal.ru/unstable-beta/';

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove base URL from URI
$endpoint = str_replace($base_url, '', $uri);

// Remove query parameters from the endpoint
$endpoint = strtok($endpoint, '?');

// Route the request to the appropriate endpoint
switch ($endpoint) {
    case 'testing':
        include 'testing/testing.php';
        break;
    // Add more cases for other endpoints specific to the unstable-beta version
    default:
        // Return a 404 Not Found response for unknown endpoints
        http_response_code(404);
        echo json_encode(array('message' => 'Endpoint not found'));
        break;
}

// curl -X POST -H "Content-Type: application/json" -d '{}' https://api.mpt-journal.ru/unstable-beta/testing
