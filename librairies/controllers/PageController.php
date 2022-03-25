<?php

namespace Controllers;

use Renderer;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function aPropos()
    {
        $pageTitle = 'À propos';
        Renderer::render('pages/a-propos', compact('pageTitle'));
    }
}