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

        $controllerPath = "\Controllers\\" . $controllerName;

        // Check if this controller & method exists
        if (!method_exists($controllerPath, $task)) {
            Http::error404();
        }

        $controller = new $controllerPath();
        $controller->$task();
    }
}