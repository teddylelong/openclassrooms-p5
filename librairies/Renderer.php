<?php

require_once 'librairies/autoload.php';

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
     * @param bool $toAdminPage
     * @return void
     */
    public function render(string $path, $var = [], bool $toAdminPage = false)
    {
        // echo 'lol'; die();
        $template = self::loadTwig()->load("$path.html.twig");
        echo $template->display($var);
    }

    /**
     * Load Twig
     *
     * @return Environment
     */
    public function loadTwig()
    {
        $loader = new FilesystemLoader('templates');

        $twig = new Environment($loader, [
            'auto_reload' => true,
            'autoescape' => 'html'
        ]);
        $twig->addFunction(
            new TwigFunction('notificationDisplay', function() { return Notification::display(); })
        );
        return $twig;
    }
}