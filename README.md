# PHP Router
##### simple as it gets 

Trying out a custom router with php.

Its a basic router that handles requests.At the moment its very basic.It only supports GET and POST requests.Also you can use controller
or closure for handling route functionalities.

Will add route parameters (optional and required),Middleware pipeline (similar to laravel) and method injection in the next version/s.

#### How to use 

The index file works as the router. To run the applicaiton simply run


```
 php -S 127.0.0.1:8000
```

and It will serve on your localhost:8000 

#### Adding routes

```
$router->get('/endpoint',function() { /** your logic here */ });

$router->get('/endpoint','YourController::methodName');
```

Same for the post routes

```
$router->post('/endpoint','YourController::methodName');
```

The namespace can be injected (passed as a parameter when creating the **$router** object in **index.php**. 
By default its the *Controllers* folder inside the *src* directory.

playtime project. :) 
