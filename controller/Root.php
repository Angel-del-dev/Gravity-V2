<?php

namespace controller;

class Root {
    public function GetRoot() {
        print_r('Hello root');
        exit;
    }

    public function GetNotFound():array {
        return [ 'code' => 404 ];
    }
}