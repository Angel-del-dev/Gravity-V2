<?php

use lib\components\Route;
use controller\Root;
use controller\Test;

Route::Get("/", Root::class, 'GetRoot');
Route::Get("*.*", Root::class, 'GetNotFound');