<?php

function render(string $path, array $var = [])
{
    extract($var);
    ob_start();
    require('templates/' . $path . '.html.php');
    $pageContent = ob_get_clean();

    require('templates/layout.html.php');
}

function redirect(string $url): void
{
    header('Location: '.$url);
    exit();
}
