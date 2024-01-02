<?php

use \Clarity\Routing\Route;


Route::get('/api/{version}/test/{var?}', function () {
    return 'Hi';
});