<?php

if (!function_exists('md')) {
    function md($text)
    {
        return preg_replace("/(`)(.*?)(`)/", '<options=bold>$2</>' ,$text);
    }
}
