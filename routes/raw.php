<?php

use lib\components\Route;
use controller\Root;
use controller\Test;

Route::Get("/", Root::class, 'GetRoot');
Route::Get("/test/{bye:string}/test/{id:int}", Test::class, 'GetTest');
Route::Get("*.*", Root::class, 'GetNotFound');