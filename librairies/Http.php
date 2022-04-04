<?php

class Http
{
    /**
     * Redirect web browser to given $url
     *
     * @param string $url
     * @return void
     */
    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }

    /**
     * Display a 404 error - page not found
     *
     * @return void
     */
    public static function error404(): void
    {
        header('HTTP/1.1 404 Not Found');

        $renderer = new Renderer();

        $pageTitle = "Erreur 404 - Page non-trouvée";
        $renderer->render('errors/404', compact('pageTitle'));
    }
}