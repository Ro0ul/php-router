# php-router
## A Simple PHP Router , that i'm still working on .

## Composer Usage
```
composer require roul/router
```

### Usage
```php
Route::get("/",function(){/*Do Something Here*/});
Route::get("/user/{username}",function($username){/*Do Something Here Too*/});
Route::get("/no-access/",function(){})->middleware(Middleware::class);
```
#### Finally 
```php
Route::run();
```

## Middleware
```php
class Middleware{
  # The Handle Method is the only method that's going to be called inside the middleware class
  public function handle(mixed $next,array $params = []) : mixed
  {
    return $next($params);
  }
}
```
## notFound
```php
  Route::setNotFound(function(){
    # Not Found
  });
```
