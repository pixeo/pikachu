<?php

if (!function_exists('md')) {
    function md($text)
    {
        return app(\App\Services\Markdown::class)->parse($text);
    }
}
