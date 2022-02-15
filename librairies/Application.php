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

        // Controller full name
        $controllerName = "\Controllers\\" . $controllerName;

        // Check if controller & method exists
        if (!method_exists($controllerName, $task)) {
            header('HTTP/1.1 404 Not Found');
            $controllerName = 'Error';
            $task = 'show';
            $controllerName = "\Controllers\\" . $controllerName; // TODO Solve duplication ?
        }

        $controller = new $controllerName();
        $controller->$task();
    }
}