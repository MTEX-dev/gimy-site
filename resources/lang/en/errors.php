<?php

return [
    '401' => [
        'title' => 'Unauthorized',
        'description' => 'You are not authorized to access this page.',
    ],
    '403' => [
        'title' => 'Forbidden',
        'description' => 'You do not have permission to access this resource.',
    ],
    '404' => [
        'title' => 'Page Not Found',
        'description' => 'The page you are looking for could not be found.',
    ],
    '419' => [
        'title' => 'Page Expired',
        'description' => 'The page has expired due to inactivity. Please refresh and try again.',
    ],
    '429' => [
        'title' => 'Too Many Requests',
        'description' => 'You have sent too many requests in a given amount of time.',
    ],
    '500' => [
        'title' => 'Server Error',
        'description' => 'Oops, something went wrong on our end.',
    ],
    '503' => [
        'title' => 'Service Unavailable',
        'description' => 'The server is currently unable to handle the request due to a temporary overloading or maintenance of the server.',
    ],

    'ModelNotFoundException' => [
        'title' => 'Resource Not Found',
        'description' => 'The requested resource could not be found.',
    ],

    'ViewException' => [
        'title' => '',
        'description' => '',
    ],

    'fallback' => [
        'title' => 'Something Went Wrong',
        'description' => 'An unexpected error occurred. Please try again later.',
    ],
];