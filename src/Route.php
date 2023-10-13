<?php declare(strict_types=1);

namespace RoulRouter;

class Route 
{
    private static array $routes = [];
    public static function get(string $url, callable $callback) : void 
    {
        static::$routes[] = [$url , $callback, "get"];
    }
    public static function get(string $url, callable $callback) : void 
    {
        static::$routes[] = [$url , $callback, "post"];
    }
    public static function get(string $url, callable $callback) : void 
    {
        static::$routes[] = [$url , $callback, "put"];
    }
    public static function get(string $url, callable $callback) : void 
    {
        static::$routes[] = [$url , $callback, "delete"];
    }
    public static function run() : mixed 
    {
        $requestUrl = $_SERVER["REQUEST_URI"];
        $requestMethod = strtolower($_SERVER["REQUEST_METHOD"]);
        $requestUrl = trim($requestUrl,"/");
        $callback = null;
        $params = [];
        foreach(static::$routes as $route){
            $uri = $route[0];
            $method = $route[2];
            if($requestMethod != $method){
                break;
            }
            $uri = trim($uri,"/");
            
            if(preg_match("%^{$uri}$%",$requestUrl,$matches)){
                $callback = $route[1];
                unset($matches[0]);
                $params = $matches;
                break;
            }
        }
        if($callback){
            return call_user_func_array($callback,$params);
        }
        echo "404";
        return false;
    }
}
