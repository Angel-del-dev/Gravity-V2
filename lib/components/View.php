<?php

namespace lib\components;

class View {
    /**
     * /
     * @param string $view_route already points to '/views/'
     * 
     * @param string $view_route must not contain a file extension
     */
    static function Render(string $view_route, array $params = [], bool $useViewSystem = false):ViewRenderer {
        return new ViewRenderer($view_route, $params, $useViewSystem);
    }
}
/**
 * Use @class ViewRenderer only as return types
 */
class ViewRenderer {
    protected string $view_route;
    protected string $route_prefix;
    protected string $extension;
    protected array $params;
    protected bool $useViewSystem;
    public function __construct(string $view_route, array $params, bool $useViewSystem) {
        $this->view_route = $view_route;
        $this->route_prefix = "{$_SERVER['DOCUMENT_ROOT']}/../views";
        $this->extension = 'phtml';
        $this->params = $params;
        $this->useViewSystem = $useViewSystem;
    }

    public function Render() {
        if($this->useViewSystem) ob_start();
        foreach($this->params as $key => $value) {
            ${$key} = $value;
        }
        require_once "{$this->route_prefix}/{$this->view_route}.{$this->extension}";
        if($this->useViewSystem) echo (new ViewParser(ob_get_clean()))->Parse($this->params);
    }
}

class ViewParser {
    private string $html;
    private string $final_html;
    private int $length;
    private array $params;
    public function __construct(string $html) {
        $this->html = $html;
        $this->final_html = $html;
        $this->length = strlen($html);
        $this->params = [];
    }

    private function ModifyHtml(int $begin, int $end, string $content):void {
        $before = substr($this->final_html, 0, $begin);
        $after = substr($this->final_html, $end);
        $this->final_html = "{$before}{$content}{$after}";
    }

    private function AdvanceToDelimiters(int $i, array $delimiters) :int {
        for($j = $i ; $j < $this->length ; $j++) {
            $ch = $this->html[$j];
            if(in_array($ch, $delimiters)) {
                $i = $j;
                break;
            }
        }
        return $i;        
    }

    private function ComputeVar(int $j):string {
        $old_j = $j + 1;
        $j = $this->AdvanceToDelimiters($j, [')']);
        return substr($this->html, $old_j, $j - $old_j);
    }

    private function ComputeOperation(int $i, int $j) :int{
        $operation = substr($this->html, $i + 1, $j - ($i + 1) );
        $error = '';
        switch(strtoupper($operation)) {
            case 'VAR':
                $var = $this->ComputeVar($j);
                
                $j += strlen($this->params[$var]) - 1;
                if(!isset($this->params[$var])) {
                    print_r("Variable not found {$var}");
                    exit;
                }
                $this->ModifyHtml($i, $j, $this->params[$var]);
            break;
            default:
                $error = "Tag uknown @{$operation}";
            break;
        }
        if($error != '') {
            print_r($error);
            exit;
        }
        return $j;
    }

    private function Loop() {
        for($i = 0 ; $i < $this->length ; $i++) {
            $ch = $this->html[$i];
            if($ch != '@') continue;
            $j = $this->AdvanceToDelimiters($i, [' ', '(']);
            $i = $this->ComputeOperation($i, $j);
        }
    }

    public function Parse(array $params):string {
        $this->params = $params;
        $this->Loop();
        return $this->final_html;
    }
}