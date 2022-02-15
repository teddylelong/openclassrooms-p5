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
        exit;
    }
}