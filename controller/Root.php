<?php

namespace controller;

use lib\render\View;
use lib\response\Response;
use lib\Response\ResponseType;

class Root {
    public function GetRoot() {
        return View::Render('simple/Root', [
            'first' => 'test templating',
            'second' => '23',
            'third' => 'uknown'
        ], ['view']);
        //return Response::Handle(['code' => 200], 'text/json');
    }

    public function GetNotFound():array {
        return [ 'code' => 404, 'message' => 'Route not found' ];
    }
}