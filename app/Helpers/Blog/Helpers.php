<?php


if (!function_exists('getPostStatus')) {
    function getPostStatus()
    {
        return [0 => 'draft', 1 => 'pending', 2 => 'published'];
    }
}

if (!function_exists('getPostStatusByIndex')) {
    function getPostStatusByIndex($index)
    {
        $status = getPostStatus();
        return $status[$index];
    }
}
