<?php

if (! function_exists('get_stub')) {
    /**
     * @param  string  $path
     *
     * @return string
     */
    function get_stub(string $path): string
    {
        return file_get_contents(__DIR__.'/../../stubs/'.$path);
    }
}
