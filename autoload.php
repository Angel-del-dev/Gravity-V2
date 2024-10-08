<?php

spl_autoload_register(function ($className) {
    $file = '../'.str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
    
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});