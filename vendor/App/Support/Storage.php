<?php

namespace Clarity\Support;

class Storage {
    public static function storage_path($path): string {
        $path = rtrim(ltrim($path, '/'), '/');
        return "storage/$path";
    }
}


function storage_path($path): string {
    return Storage::storage_path($path);
}

function base_path() {

}
