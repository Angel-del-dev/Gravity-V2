<?php

namespace controller;

use lib\components\View;
use lib\components\ViewRenderer;

class Root {
    public function GetRoot():ViewRenderer {
        return View::Render('simple/Root', [
            'first' => 'test templating',
            'second' => '23',
            'third' => 'uknown'
        ]);
    }

    public function GetNotFound():array {
        return [ 'code' => 404 ];
    }
}