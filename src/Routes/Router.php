<?php

namespace Src\Routes;
use Closure;
use Exception;

class Router {
    protected $routes = [];

    public function addRoute(string $method, string $url, closure $target){
        $this->routes[$method][$url] = $target;
    }

    public function matchRoute(){
        $method = $_SERVER['REQUEST_METHOD'];
        $url = rtrim($_SERVER['REQUEST_URI']);
        if(isset($this->routes[$method])){
            foreach($this->routes[$method] as $routeUrl => $target){
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {

                    $params = array_filter($matches,'is_string', ARRAY_FILTER_USE_KEY);
                    call_user_func($target,$params);
                
                }
            }
        }else {
            throw new Exception('Route not found');
        }
    }
}