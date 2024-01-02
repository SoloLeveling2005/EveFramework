<?php

//namespace Clarity\Support\Directory;

class DirectoryPath {
    public static function storage_path($path): string
    {
        return 'storage/'.ltrim(rtrim($path, '/'), '/');
    }
    public static function route_path($path): string
    {
        return 'routes/'.ltrim(rtrim($path, '/'), '/');
    }
}

function storage_path($path): string
{
    return ltrim(rtrim(DirectoryPath::storage_path($path), '/'), '/');
}

function route_path($path): string
{
    return ltrim(rtrim(DirectoryPath::route_path($path), '/'), '/');
}
