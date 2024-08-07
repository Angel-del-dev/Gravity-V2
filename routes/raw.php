<?php

use lib\components\Route;
use controller\Root;
use controller\Test;

Route::Get("/", Root::class, 'GetRoot');
Route::Get("/test/{id:int}/greet/{name:string}", Root::class, 'GetParams');
Route::Get("*.*", Root::class, 'GetNotFound');