<?php

if (! function_exists('api_response')) {
    function api_response($content = '', $status = 200, array $headers = [])
    {
        return response()->api($content, $status, $headers);
    }
}

if (! function_exists('api_error')) {
    function api_error($content = '', $status = 400, array $headers = [])
    {
        return response()->api_error($content, $status, $headers);
    }
}
