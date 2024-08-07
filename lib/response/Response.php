<?php

namespace lib\Response;

use lib\response\ResponseType;
use lib\response\ValidResponse;

class Response {
    static public function Handle($response, string $type = 'text/json'):ResponseType {
        return new ResponseType($response, ValidResponse::GetValidResponseType($type));                
    }
}