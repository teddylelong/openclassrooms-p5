<?php

class Application
{
    /**
     * This is the app process, called in index.php file.
     * Use controllers and methods directly in URL.
     * URL are rewritten by .htaccess file at app root.
     *
     * Usage :    https://domain.com/controller/task/{optionnal_parameter}
     *            Ex : https://domain.com/article/show/145
     *
     * @return void
     */
    public static function process()
    {
        $controllerName = filter_input(INPUT_GET, 'controller');
        $task = filter_input(INPUT_GET, 'task');

        // By default, call homepage
        if (empty($controllerName)) {
            $controllerName = 'Article';
        }

        if (empty($task)) {
            $task = 'home';
        }

        $controllerPath = "\controllers\\" . ucfirst($controllerName) . 'Controller';

        // Check if this controller & method exists
        if (!method_exists($controllerPath, $task)) {
            Http::error404();
        }

        $controller = new $controllerPath();
        $controller->$task();
    }
}