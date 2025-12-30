<?php

function error($message)
{
    // Return an associative array with success as false and a message
    return [
        'success' => false,
        'message' => $message
    ];
}

function success($message)
{
    // Return a success message in the same format
    return [
        'success' => true,
        'message' => $message
    ];
}


return [
    "Argument" => error("Invalid arguments"),
    "Requst" => error("Invalid request method")
];
