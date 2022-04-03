<?php

class Http
{
    /**
     * Redirect web browser to given $url
     *
     * @param string $url
     * @return void
     */
    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        return;
    }

    /**
     * Display a 404 error - page not found
     *
     * @return void
     */
    public static function error404(): void
    {
        header('HTTP/1.1 404 Not Found');
        $pageTitle = "Erreur 404 - Page non-trouvée";
        Renderer::render('errors/404', compact('pageTitle'));
        return;
    }
}