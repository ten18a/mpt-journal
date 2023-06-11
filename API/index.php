<?php

// APIv:
$apiv = 'unstable-beta';

// Define base URL
$base_url = 'https://api.mpt-journal.ru/unstable-beta/';

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];

$endpoint = $_GET['endpoint'];

// Route the request to the appropriate endpoint
switch ($endpoint) {
    case 'apiv':
        echo "$apiv";
    break;
    // Add more cases for other endpoints specific to the unstable-beta version
    default:
        // Return a 404 Not Found response for unknown endpoints
        http_response_code(404);
        echo json_encode(array('message' => 'Endpoint not found'));
        break;
}
