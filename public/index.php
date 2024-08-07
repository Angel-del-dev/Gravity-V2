<?php
require_once '../autoload.php';
require_once '../routes/raw.php';

use lib\components\Route;
use lib\Response\ResponseType;
use lib\render\ViewRenderer;

function sortByLength($a,$b){
    return strlen($b['ROUTE'])-strlen($a['ROUTE']);
}

$routes_data = Route::_GetRoutes($_SERVER['REQUEST_METHOD']);

if($routes_data === false) {
    print_r('Method not allowed, Please contact the administrator');
    exit;
}

$routes = $routes_data[0];
$not_found = $routes_data[1] ?? null;

usort($routes,'sortByLength');

$req_uri = $_SERVER['REQUEST_URI'];

$format_req_uri = explode('/', $req_uri);
$req_uri_amount_slashes = count($format_req_uri) - 1;
$routes = $routes_data[0];

$selected_route = null;
foreach($routes as $route) {
    $format_route = explode('/', $route['ROUTE']);
    $route_amount_slashes = count($format_route) - 1;
    if($route_amount_slashes != $req_uri_amount_slashes) continue;
    
    for($i = 0 ; $i < $route_amount_slashes + 1; $i++) {
        if($req_uri_amount_slashes + 1 < $i) break;
        
        $req_actual = $format_req_uri[$i];
        $route_actual = $format_route[$i];
        $params_ok = false;
        if(
            $route_actual != '' && 
            $route_actual[0] == '{' && 
            $route_actual[strlen($route_actual) - 1] == '}' &&
            $req_actual != ''
        ) {
            $params_ok = true;
            $actual_clean = str_replace('{', '', $route_actual);
            $actual_clean = str_replace('}', '', $actual_clean);
            $array_separated = explode(':', $actual_clean);
            $value = $req_actual;
            // If the route definition does not specify a date, its a string by default
            if(count($array_separated) > 1) {
                switch(strtoupper($array_separated[1])) {
                    case 'INT':
                        $value = (int) $value;
                    break;
                    case 'STRING':
                        // Not necessary but defines the type string
                        $value = (string) $value;
                    break;
                    default:
                        print_r('Route type not known');
                        exit;
                    break;
                }
            }
            
            $route['PARAMS'][] = $value;
        }
        
        if(
            $req_actual != $route_actual &&
            !$params_ok
        ) {
            $route['PARAMS'] = [];
            break;
        }
        if($i == $route_amount_slashes) {
            $selected_route = $route;
            break;
        }
    }
    if(!is_null($selected_route)) break;
}

$output = null;

if (is_null($selected_route)) {
    // Handle route not found
    if(is_null($not_found)) {
        print_r('Default route for 404 not defined');
        exit;
    }
    $class = new $not_found['CLASS']();
    $fn = $not_found['FN'];
    $output = $class->$fn();

} else {
    $class = new $selected_route['CLASS']();
    $fn = $selected_route['FN'];
    $output = $class->$fn(...$selected_route['PARAMS']);
}

if(!is_null($output)) {
    if(is_array($output)) {
        echo json_encode($output);
        exit;
    }
    
    if($output instanceof ViewRenderer) {
        $output->Render();
    }

    if($output instanceof ResponseType) {
        echo $output->getResponse();
    }
}