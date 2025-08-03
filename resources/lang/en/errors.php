<?php

return [
    '401' => [
        'title' => 'Unauthorized Access',
        'description' => 'You need proper authentication credentials to access this page. Please log in or verify your identity.',
    ],
    '403' => [
        'title' => 'Access Forbidden',
        'description' => 'You do not have the necessary permissions to view this content. If you believe this is an error, please contact support.',
    ],
    '404' => [
        'title' => 'Page Not Found',
        'description' => 'We couldn\'t find the page you were looking for. It might have been moved, deleted, or you might have typed the address incorrectly.',
    ],
    '419' => [
        'title' => 'Page Expired',
        'description' => 'Your session has expired due to inactivity. Please refresh the page and try your action again.',
    ],
    '429' => [
        'title' => 'Too Many Requests',
        'description' => 'You\'ve sent too many requests in a short period. Please wait a moment before trying again.',
    ],
    '500' => [
        'title' => 'Internal Server Error',
        'description' => 'Oops! Something went wrong on our end. We\'re working to fix it. Please try again shortly.',
    ],
    '503' => [
        'title' => 'Service Unavailable',
        'description' => 'We\'re undergoing maintenance or experiencing temporary overload. We\'ll be back online very soon!',
    ],

    'ModelNotFoundException' => [
        'title' => 'Resource Not Found',
        'description' => 'The specific item or record you were looking for does not exist.',
    ],
    'ViewException' => [
        'title' => 'View Rendering Error',
        'description' => 'There was an issue displaying the page. Please report this to support if it persists.',
    ],
    'InvalidArgumentException' => [
        'title' => 'Invalid Input',
        'description' => 'The system received an unexpected or incorrect value. Please ensure your input is valid.',
    ],

    'fallback' => [
        'title' => 'An Unexpected Error Occurred',
        'description' => 'We\'re truly sorry, but something entirely unforeseen happened. Our team has been notified. Please try again later.',
    ],
];