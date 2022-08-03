<?php

namespace App\Core;




class Router
{
    protected $routes = [];
    protected $params = [];


    public function __construct()
    {
        $arr = require_once   __DIR__ .'/../config/routes.php';
        foreach ($arr as $route) {
            $this->add($route);
        }
    }

    public function add(array $route): void
    {
        $uri = $route['uri'];
        $route['uri'] ="#^$uri$#";
        $this->routes[] = $route;
    }

    public function match(): bool
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = str_replace('/public/','', $_SERVER['REQUEST_URI']);
        $uri = explode('?', $uri, 2)[0];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['uri'], $uri, $matches)) {
                $this->params = $route;
                return true;
            }
        }
        return false;
    }



    public function run(): void
    {
        if (!$this->match()) {
            echo "Маршрут не найден";
        } else {
            $this->call();
        }
    }


    protected function call():void
    {
        $class =  $this->params['controller'];

        if (!class_exists($class)) {
            echo "Класса нет";
        } else {
            $action = $this->params['action'];
            if (!method_exists($class, $action)) {
                echo "Метода класса нет";
            } else {
                $controller = new $class;
                $controller->$action();
            }
        }
    }
}