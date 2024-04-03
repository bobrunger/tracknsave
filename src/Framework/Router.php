<?php

declare(strict_types=1);

namespace Framework;

class Router {
    private array $routes = [];
    private array $middlewares = [];
    private array $errorHandler;

    public function add(string $method, string $path, array $controller) {
        $path = $this->normalizePath($path);

        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }
    //    /about/blabla/
    private function normalizePath(string $path): string {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }

    public function dispatch(string $path, string $method, Container $container = null) {
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);


        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['regexPath']}$#", $path, $paramValues) || $route['method'] !== $method) {
                //echo 'not found';

                continue;
            }

            array_shift($paramValues);

            preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);

            $paramKeys = $paramKeys[1];

            $params = array_combine($paramKeys, $paramValues);


            //echo 'route found';
            [$class, $function] = $route["controller"]; // route is array of class name and method
            $controllerInstance = $container ?
                $container->resolve($class) : new $class; // class name have full namespace such as App\Controllers\HomeController

            $action = fn () => $controllerInstance->{$function}($params); // eg home() method

            $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

            foreach ($allMiddleware as $middleware) {
                $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware;
                $action = fn () => $middlewareInstance->process($action); // controller will be last class to execute
            }

            $action();
            return; // prevent another route from running
        }

        $this->dispatchNotFound($container);
        //dd($this->routes);
    }

    public function addMiddleware(string $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware) {
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }

    public function setErrorHandler(array $controller) {
        $this->errorHandler = $controller;
    }

    public function dispatchNotFound(?Container $container) {
        [$class, $function] = $this->errorHandler;

        $controllerInstance = $container ? $container->resolve($class) : new $class;
        $action = fn () => $controllerInstance->$function();

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ? $container->resolve($middleware) : new $class;
            $action = fn () => $middlewareInstance->process($action);
        }

        $action();
    }
}
