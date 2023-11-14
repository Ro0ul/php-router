<?php declare(strict_types=1);


namespace Roul\Router;

/**
 * Route
 */
class Route 
{
    private static array $routes = [];
    private static mixed $notFound = null;
    /**
     * Register a GET Route
     */
    public static function get(string $url, mixed $callback) : self 
    {
        static::$routes[] = [$url , $callback, "get"];
        return new Route();
    }
     /**
     * Register a POST Route
     */
    public static function post(string $url, mixed $callback) : self 
    {
        static::$routes[] = [$url , $callback, "post"];
        return new Route();
    }
     /**
     * Register a DELETE Route
     */
    public static function delete(string $url, mixed $callback) : self 
    {
        static::$routes[] = [$url , $callback, "delete"];
        return new Route();
    }
     /**
     * Register a PUT Route
     */
    public static function put(string $url, mixed $callback) : self 
    {
        static::$routes[] = [$url , $callback, "put"];
        return new Route();
    }
     /**
     * Register a PATCH Route
     */
    public static function patch(string $url, mixed $callback) : self 
    {
        static::$routes[] = [$url , $callback, "patch"];
        return new Route();
    }

    /**
     * Adds A Middleware To Your Route
     */
    public static function middleware(string $name)
    {
        static::$routes[array_key_last(static::$routes)]["middleware"] = $name;

    }
    public static function setNotFound(mixed $callback) : void 
    {
        static::$notFound = $callback;  
    }
    public static function run(
        ?string $requestUrl = null,
        ?string $requestMethod = null
    ) : mixed 
    {
        $requestUrl = $requestUrl ?? $_SERVER["REQUEST_URI"];
        $requestMethod = $requestMethod ?? strtolower($_SERVER["REQUEST_METHOD"]);
        $requestUrl = trim($requestUrl,"/");
        $callback = null;
        $params = [];
        foreach(static::$routes as $route){
            $uri = $route[0];
            $uri = preg_replace('/{[^}]+}/',"(.+)",$uri);
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
            $middleware = $route["middleware"] ?? null;
            if(!is_null($middleware)){
                $class = $middleware;
                $class = new $class();
                return $class->handle($callback,$params); # You Can Modify How The function is called here 
            }
            if(is_callable($callback) or is_string($callback)){
                return call_user_func($callback,$params);  # You Can Modify How The function is called here 
            }
            if(is_array($callback)){
                [$class, $method] = $callback;
                $class = new $class;
                return $class->$method(); # You Can Modify How The function is called here 
            }
        }
        if(!is_null(static::$notFound)){
            if(is_callable(static::$notFound) or is_string(static::$notFound)){
                return call_user_func(static::$notFound);  # You Can Modify How The function is called here 
            }
            if(is_array(static::$notFound)){
                [$class, $method] = static::$notFound;
                $class = new $class;
                return $class->$method(); # You Can Modify How The function is called here 
            }
        }
        throw new \Exception("404 Method Not Set");
    }
}
