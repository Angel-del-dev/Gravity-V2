<?php

namespace controller;

use lib\components\View;
use lib\components\ViewRenderer;

class Test {
    function GetTest(string $first, int $second):ViewRenderer {
        return View::Render('simple/test', [
            'word' => $first,
            'id' => $second
        ]);
    }
}