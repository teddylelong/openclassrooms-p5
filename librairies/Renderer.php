<?php

class Renderer
{
    /**
     * Print a HTML template with $var injection
     * @param string $path
     * @param array $var
     * @return void
     */
    public static function render(string $path, array $var = [], $toAdminPage = false)
    {
        extract($var);
        ob_start();
        require('templates/' . $path . '.html.php');
        $pageContent = ob_get_clean();

        if ($toAdminPage) {
            require 'templates/adminlayout.html.php';
        }
        else {
            require('templates/layout.html.php');
        }
    }
}