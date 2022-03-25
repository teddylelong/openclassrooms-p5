<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Renderer
{
    /**
     * Print a HTML template with $var injection
     *
     * @param string $path
     * @param array $var
     */
    public static function render(string $path, $var = [])
    {
        $template = self::loadTwig()->load("$path.html.twig");
        echo $template->display($var);
    }

    /**
     * Load Twig
     *
     * @return Environment
     */
    public static function loadTwig()
    {
        $loader = new FilesystemLoader('templates');

        $twig = new Environment($loader, [
            'auto_reload' => true,
            'autoescape' => false
        ]);

        // Twig functions
        $twig->addFunction(
            new TwigFunction('notificationDisplay', function() { return Notification::display(); })
        );

        $twig->addFunction(
            new TwigFunction('echoActiveClass', function($requestUri) {
                if ($_SERVER['REQUEST_URI'] == $requestUri)
                    echo 'active';
            })
        );

        // Twig globals vars
        $twig->addGlobal('session', $_SESSION);

        return $twig;
    }
}