<?php

namespace Controllers;

use Renderer;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Render "A propos" static page
     *
     * @return void
     */
    public function aPropos()
    {
        $pageTitle = 'À propos';
        Renderer::render('pages/a-propos', compact('pageTitle'));
    }

    /**
     * Render "Mentions légales" static page
     *
     * @return void
     */
    public function mentionsLegales()
    {
        $pageTitle = 'Mentions légales';
        Renderer::render('pages/mentions-legales', compact('pageTitle'));
    }

    /**
     * Render "Données personnelles" static page
     *
     * @return void
     */
    public function donneesPersonnelles()
    {
        $pageTitle = "Données personnelles";
        Renderer::render('pages/donnees-personnelles', compact('pageTitle'));
    }

    /**
     * Render "Mon CV" static page
     *
     * @return void
     */
    public function monCv()
    {
        $pageTitle = "Mon CV";
        Renderer::render('pages/mon-cv', compact('pageTitle'));
    }
}