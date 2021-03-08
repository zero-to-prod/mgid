<?php

use GuzzleHttp\Psr7\Response;

if (! function_exists('response')) {
    /**
     * @param  string  $content
     * @param  int  $status
     * @param  array  $headers
     *
     * @return Response
     */
    function response($content = '', $status = 200, array $headers = []): Response
    {
        return new Response($status, $headers, $content);
    }
}
