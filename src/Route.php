<?php declare(strict_types=1);

namespace RoulRouter;

class Route
{
    private array $routes = [];
    public function __construct(
        private string $requestUrl,
        private string $requestMethod
    ){}
    public function get(string $url,$callback) : void 
    {
        $this->routes[] = ["get" , $url, $callback];
    }
    public function post(string $url,$callback) : void 
    {
        $this->routes[] = ["post" , $url, $callback];
    }
    public function put(string $url,$callback) : void 
    {
        $this->routes[] = ["put" , $url, $callback];
    }
    public function delete(string $url,$callback) : void 
    {
        $this->routes[] = ["delete" , $url, $callback];
    }
    public function run()
    {

        $callback = null;

        foreach($this->routes as $route){
            $routeMethod = $route[0];
            $routeUrl = $route[1];
            $routeCallback = $route[2];

            if($this->requestMethod == $routeMethod){
                if($this->requestUrl == $routeUrl){
                    $callback = $routeCallback;
                    break;
                }
            }
        }

        if($callback){
            return call_user_func_array($callback, []);
        }
        echo "404";
    }

}