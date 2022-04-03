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
    public static function render(string $path, $var = []): void
    {
        $template = self::loadTwig()->load("$path.html.twig");
        $template->display($var);
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
                if (filter_input(INPUT_SERVER, 'REQUEST_URI') == $requestUri)
                    return 'active';
            })
        );

        $twig->addFunction(
            new TwigFunction('markdown', function($text) {
                $parsedown = new Parsedown();
                return $parsedown->parse($text);
            })
        );

        // Twig globals vars
        $twig->addGlobal('session', $_SESSION);

        return $twig;
    }
}