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
        // By default, call articles lists
        $controllerName = 'ArticleController';
        $task = 'home';

        if (!empty($_GET['controller'])) {
            $controllerName = ucfirst($_GET['controller'] . 'controller');
        }

        if (!empty($_GET['task'])) {
            $task = $_GET['task'];
        }

        $controllerPath = "\controllers\\" . $controllerName;

        // Check if this controller & method exists
        if (!method_exists($controllerPath, $task)) {
            // /!\ Si je vire cette ligne, erreur :
            // new Controllers\Article();
            Http::error404();
        }

        $controller = new $controllerPath();
        $controller->$task();
    }
}