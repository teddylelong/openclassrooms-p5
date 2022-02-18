<?php

class Application
{
    public static function process()
    {
        $controllerName = 'Article';
        $task = 'index';

        if (!empty($_GET['controller'])) {
            $controllerName = ucfirst($_GET['controller']);
        }

        if (!empty($_GET['task'])) {
            $task = $_GET['task'];
        }

        // Get Controller full name
        $controllerPath = self::getControllerPath($controllerName);

        // Check if this controller & method exists
        // If not, call 404 controller
        if (!method_exists($controllerPath, $task)) {
            header('HTTP/1.1 404 Not Found');
            $controllerName = 'Error';
            $task = 'show404';
            $controllerPath = self::getControllerPath($controllerName);
        }

        $controller = new $controllerPath();
        $controller->$task();
    }

    public static function getControllerPath($name): string
    {
        return "\Controllers\\" . $name;
    }
}