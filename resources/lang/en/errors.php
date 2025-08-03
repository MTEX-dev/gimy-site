<?php

return [
    '400' => [
        'title' => 'Bad Request',
        'description' => 'The server cannot process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).',
    ],
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
    '405' => [
        'title' => 'Method Not Allowed',
        'description' => 'The HTTP method used for the request is not supported for the requested resource.',
    ],
    '408' => [
        'title' => 'Request Timeout',
        'description' => 'The server timed out waiting for the request. This can happen due to network issues or slow client responses.',
    ],
    '413' => [
        'title' => 'Payload Too Large',
        'description' => 'The request entity is larger than limits defined by server; the server might close the connection or return an "Retry-After" header field.',
    ],
    '414' => [
        'title' => 'URI Too Long',
        'description' => 'The URI provided was too long for the server to process. This is rarely caused by valid user input.',
    ],
    '418' => [
        'title' => 'I\'m a Teapot',
        'description' => 'This is an April Fools\' joke response code from 1998, indicating the server refuses to brew coffee because it is, in fact, a teapot.',
    ],
    '419' => [
        'title' => 'Page Expired',
        'description' => 'Your session has expired due to inactivity or a security token mismatch. Please refresh the page and try your action again.',
    ],
    '422' => [
        'title' => 'Unprocessable Entity',
        'description' => 'The server understands the content type of the request entity, and the syntax of the request entity is correct, but it was unable to process the contained instructions.',
    ],
    '429' => [
        'title' => 'Too Many Requests',
        'description' => 'You\'ve sent too many requests in a short period. Please wait a moment before trying again.',
    ],
    '500' => [
        'title' => 'Internal Server Error',
        'description' => 'Oops! Something went wrong on our end. We\'re working to fix it. Please try again shortly.',
    ],
    '502' => [
        'title' => 'Bad Gateway',
        'description' => 'The server, while acting as a gateway or proxy, received an invalid response from an upstream server.',
    ],
    '503' => [
        'title' => 'Service Unavailable',
        'description' => 'We\'re undergoing maintenance or experiencing temporary overload. We\'ll be back online very soon!',
    ],
    '504' => [
        'title' => 'Gateway Timeout',
        'description' => 'The server, while acting as a gateway or proxy, did not receive a timely response from an upstream server or some other auxiliary server it needed to access to complete the request.',
    ],

    'ModelNotFoundException' => [
        'title' => 'Resource Not Found',
        'description' => 'The specific item or record you were looking for does not exist.',
    ],
    'AuthenticationException' => [
        'title' => 'Authentication Required',
        'description' => 'You must be logged in to perform this action. Please log in to continue.',
    ],
    'AuthorizationException' => [
        'title' => 'Permission Denied',
        'description' => 'You are not authorized to perform this action. If you believe this is an error, please contact support.',
    ],
    'NotFoundHttpException' => [
        'title' => 'Page Not Found',
        'description' => 'The requested URL was not found on this server. Please check the address and try again.',
    ],
    'MethodNotAllowedHttpException' => [
        'title' => 'Method Not Allowed',
        'description' => 'The HTTP method used for this request is not supported for this resource.',
    ],
    'ValidationException' => [
        'title' => 'Validation Error',
        'description' => 'One or more of your inputs were invalid. Please review the form and try again.',
    ],
    'ThrottleRequestsException' => [
        'title' => 'Too Many Requests',
        'description' => 'You\'ve sent too many requests in a short period. Please wait a moment before trying again.',
    ],
    'ViewException' => [
        'title' => 'View Rendering Error',
        'description' => 'There was an issue displaying the page. Please report this to support if it persists.',
    ],
    'InvalidArgumentException' => [
        'title' => 'Invalid Input',
        'description' => 'The system received an unexpected or incorrect value. Please ensure your input is valid.',
    ],
    'QueryException' => [
        'title' => 'Database Error',
        'description' => 'An error occurred while processing your request on the database. Our team has been notified.',
    ],

    'fallback' => [
        'title' => 'An Unexpected Error Occurred',
        'description' => 'We\'re truly sorry, but something entirely unforeseen happened. Our team has been notified. Please try again later.',
    ],
];