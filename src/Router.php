<?php 

namespace Prophecy\Router;

use Prophecy\Router\Exception\InvalidRouteDefinition;
use Prophecy\Router\Exceptions\MethodDoesNotExistsException;
use Prophecy\Router\Interfaces\RequestInterface;

class Router
{
    private $request;

    private $controllerNamespace;

    private $projectNamespace = "\Prophecy\Router";

    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    /**
     * Router constructor.
     * @param RequestInterface $request
     * @param string|null $controllerNamespace
     */
    function __construct(RequestInterface $request, string $controllerNamespace = null)
    {
        $this->request = $request;

        if(!$controllerNamespace) {
            $controllerNamespace = $this->projectNamespace . '\Controllers';
        }

        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * @param $name
     * @param $args
     */
    function __call($name, $args)
    {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }
        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * @param $route
     * @return string
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '')
        {
            return '/';
        }
        return $result;
    }

    /**
     * Method not allowed
     * throw exception
     */
    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    /**
     * Not found route
     * throw method not found
     */
    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    /**
     * @throws InvalidRouteDefinition
     * @throws MethodDoesNotExistsException
     */
    function resolve()
    {

            $methodDictionary = $this->{strtolower($this->request->requestMethod)};
            $formattedRoute    = $this->formatRoute($this->request->requestUri);

            $method = $methodDictionary[$formattedRoute];

            if(is_null($method))
            {
                $this->defaultRequestHandler();
                return;
            }

            if($method instanceof \Closure) {
                echo call_user_func_array($method, array($this->request));
            } else {
                $controlHandler = explode('::',$method);

                if(count($controlHandler) !== 2) {
                    throw new InvalidRouteDefinition;
                }

                list($controllerClass,$controllerMethod) = $controlHandler;


                $classPath = $this->controllerNamespace . '\\' . $controllerClass;

                $controller = new $classPath;

                if(!method_exists($controller,$controllerMethod)) {
                    throw new MethodDoesNotExistsException($controllerClass);
                }
                echo call_user_func_array([$controller,$controllerMethod],[]);

            }

    }

    /**
     * @throws InvalidRouteDefinition
     * @throws MethodDoesNotExistsException
     */
    function __destruct()
    {
        $this->resolve();
    }
}