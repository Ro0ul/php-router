# php-router
## A Library that calls a function When a user visit a specific URL  .
## Prequesetries
  * PHP Version >= 8.1
  * Composer Installed

## Enable Routing
  To Enable Routing Follow These Steps : 
  1. Add a .htaccess file within the same directory as the index.php file
  2. Paste This :
  ```apache
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
  ```

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
